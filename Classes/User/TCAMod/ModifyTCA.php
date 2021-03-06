<?php

namespace S3b0\Ecompc\User\TCAMod;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Sebastian Iffland <sebastian.iffland@ecom-ex.com>, ecom instruments GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Backend\Utility as BackendUtility;
use TYPO3\CMS\Core\Utility as CoreUtility;

/**
 * @author     Sebastian Iffland <sebastian.iffland@ecom-ex.com>, ecom instruments GmbH
 * @package    S3b0
 * @subpackage Ecompc
 */
class ModifyTCA extends \TYPO3\CMS\Backend\Form\FormEngine {

	/**
	 * userFuncTtContentTxEcompcPackages function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTtContentTxEcompcPackages(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		// Disable for non-admins
		$PA['fieldConf']['config']['readOnly'] = !$pObj->getBackendUserAuthentication()->isAdmin();

		if ( $PA['row']['CType'] === 'list' && $PA['row']['list_type'] === \S3b0\Ecompc\Setup::CONFIGURATOR_DYN_SIGNATURE ) {
			$PA['fieldConf']['config']['foreign_table_where'] = 'AND NOT tx_ecompc_domain_model_package.multiple_select ' . $PA['fieldConf']['config']['foreign_table_where'];
		}

		// Re-render field based on the "true field type", and not as a "user"
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['type'];
		return $pObj->getSingleField_SW($PA['table'], $PA['field'], $PA['row'], $PA);
	}

	/**
	 * userFuncTtContentTxEcompcConfigurations function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTtContentTxEcompcConfigurations(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		// Disable for non-admins
		$PA['fieldConf']['config']['readOnly'] = !$pObj->getBackendUserAuthentication()->isAdmin();

		if ( $PA['row']['CType'] === 'list' && $PA['row']['list_type'] === \S3b0\Ecompc\Setup::CONFIGURATOR_DYN_SIGNATURE ) {
			$PA['fieldConf']['config']['maxitems'] = 1;
			$PA['fieldConf']['config']['appearance']['collapseAll'] = 0;
		}

		// Re-render field based on the "true field type", and not as a "user"
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['type'];
		return $pObj->inline->getSingleField_typeInline($PA['table'], $PA['field'], $PA['row'], $PA);
	}

	/**
	 * userFuncTtContentTxEcompcPricing function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTtContentTxEcompcPricing(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		return $this->getPricingFlexForm($PA, $pObj);
	}

	/**
	 * userFuncTxEcompcOptionPricing function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTxEcompcOptionPricing(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		return $this->getPricingFlexForm($PA, $pObj);
	}

	/**
	 * userFuncTxEcompcCurrencySettings function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTxEcompcCurrencySettings(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		$addWhere = \TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($PA['row']['uid']) ? ' AND NOT tx_ecompc_domain_model_currency.uid=' . $PA['row']['uid'] : '';
		if ( $rows = $pObj->getDatabaseConnection()->exec_SELECTgetRows('*', 'tx_ecompc_domain_model_currency', 'tx_ecompc_domain_model_currency.settings & ' . \S3b0\Ecompc\Setup::BIT_CURRENCY_IS_DEFAULT . $addWhere . BackendUtility\BackendUtility::BEenableFields('tx_ecompc_domain_model_currency')) ) {
			/** @var \S3b0\Ecompc\Utility\BitHandler $bitwiseFlag */
			$bitwiseFlag = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('S3b0\\Ecompc\\Utility\\BitHandler');
			$bitwiseFlag->setBits($PA['row']['settings']);
			$isCurrentMarkedAsDefault = $bitwiseFlag->isBitSet(\S3b0\Ecompc\Setup::BIT_CURRENCY_IS_DEFAULT);

			if ( $isCurrentMarkedAsDefault ) {
				foreach ( $rows as $row ) {
					$bitwiseFlag->reset()->setBits($row['settings']);
					if ( !$bitwiseFlag->isBitSet(\S3b0\Ecompc\Setup::BIT_CURRENCY_IS_DEFAULT) ) {
						continue;
					}
					$bitwiseFlag->unsetSingleBit(\S3b0\Ecompc\Setup::BIT_CURRENCY_IS_DEFAULT);
					$pObj->getDatabaseConnection()->exec_UPDATEquery(
						'tx_ecompc_domain_model_currency',
						'tx_ecompc_domain_model_currency.uid=' . $row['uid'],
						[ 'settings' => $bitwiseFlag->getBits() ]
					);
				}
			} elseif ( count($rows) > 1 ) {
				$defaultFlagSet = FALSE;
				foreach ( $rows as $row ) {
					$bitwiseFlag->reset();
					$bitwiseFlag->setBits($row['settings']);
					if ( !$bitwiseFlag->isBitSet(\S3b0\Ecompc\Setup::BIT_CURRENCY_IS_DEFAULT) ) {
						continue;
					}
					if ( !$defaultFlagSet && $bitwiseFlag->isBitSet(\S3b0\Ecompc\Setup::BIT_CURRENCY_IS_DEFAULT) ) {
						$defaultFlagSet = TRUE;
						continue;
					}
					$bitwiseFlag->unsetSingleBit(\S3b0\Ecompc\Setup::BIT_CURRENCY_IS_DEFAULT);
					$pObj->getDatabaseConnection()->exec_UPDATEquery(
						'tx_ecompc_domain_model_currency',
						'tx_ecompc_domain_model_currency.uid=' . $row['uid'],
						[ 'settings' => $bitwiseFlag->getBits() ]
					);
				}
			}
			$PA['fieldConf']['config']['items'][(int) log(\S3b0\Ecompc\Setup::BIT_CURRENCY_IS_DEFAULT, 2)][0] = '!!! FLAG ALREADY SET !!! This will cause a break in plugin functionality! Saving twice will set the flag at current record and unset flag at the other records!';
		}

		// Disable for non-admins
		$PA['fieldConf']['config']['readOnly'] = !$pObj->getBackendUserAuthentication()->isAdmin();
		// Re-render field based on the "true field type", and not as a "user"
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['type'];
		return $pObj->getSingleField_SW($PA['table'], $PA['field'], $PA['row'], $PA);
	}

	/**
	 * userFuncTxEcompcDomainModelConfigurationSku function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTxEcompcDomainModelConfigurationSku(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		$ttContent = BackendUtility\BackendUtility::getRecord('tt_content', $PA['row']['tt_content_uid'], 'CType,list_type');
		$PA['fieldConf']['config']['readOnly'] = $ttContent['CType'] === 'list' && $ttContent['list_type'] === \S3b0\Ecompc\Setup::CONFIGURATOR_DYN_SIGNATURE ?: $PA['fieldConf']['config']['readOnly'];
		// Re-render field based on the "true field type", and not as a "user"
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['type'];
		return $pObj->getSingleField_SW($PA['table'], $PA['field'], $PA['row'], $PA);
	}

	/**
	 * userFuncTxEcompcDomainModelConfigurationConfigurationCodeSuffix function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTxEcompcDomainModelConfigurationConfigurationCodeSuffix(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		$ttContent = BackendUtility\BackendUtility::getRecord('tt_content', $PA['row']['tt_content_uid'], 'CType,list_type');
		$PA['fieldConf']['config']['readOnly'] = $ttContent['CType'] === 'list' && $ttContent['list_type'] === \S3b0\Ecompc\Setup::CONFIGURATOR_SKU_SIGNATURE ?: $PA['fieldConf']['config']['readOnly'];
		// Re-render field based on the "true field type", and not as a "user"
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['type'];
		return $pObj->getSingleField_SW($PA['table'], $PA['field'], $PA['row'], $PA);
	}

	/**
	 * userFuncTxEcompcDomainModelConfigurationConfigurationCodePrefix function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTxEcompcDomainModelConfigurationConfigurationCodePrefix(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		$ttContent = BackendUtility\BackendUtility::getRecord('tt_content', $PA['row']['tt_content_uid'], 'CType,list_type');
		$PA['fieldConf']['config']['readOnly'] = $ttContent['CType'] === 'list' && $ttContent['list_type'] === \S3b0\Ecompc\Setup::CONFIGURATOR_SKU_SIGNATURE ?: $PA['fieldConf']['config']['readOnly'];
		// Re-render field based on the "true field type", and not as a "user"
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['type'];
		return $pObj->getSingleField_SW($PA['table'], $PA['field'], $PA['row'], $PA);
	}

	/**
	 * userFuncTxEcompcDomainModelConfigurationOptions function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @see \TYPO3\CMS\Backend\Form\FormEngine->getSingleField_typeSelect_checkbox
	 * @return string
	 */
	public function userFuncTxEcompcDomainModelConfigurationOptions(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		$ttContent = BackendUtility\BackendUtility::getRecord('tt_content', $PA['row']['tt_content_uid'], 'CType,list_type,tx_ecompc_packages');
		if ( $ttContent['CType'] === 'list' && $ttContent['list_type'] === \S3b0\Ecompc\Setup::CONFIGURATOR_DYN_SIGNATURE ) {
			return '';
		}

		// Creating the label for the "No Matching Value" entry.
		$nMV_label = isset($PA['fieldTSConfig']['noMatchingValue_label']) ? $this->sL($PA['fieldTSConfig']['noMatchingValue_label']) : '[ ' . $this->getLL('l_noMatchingValue') . ' ]';
		// Prepare some values:
		$config = $PA['fieldConf']['config'];

		$configurationPackages = $ttContent['tx_ecompc_packages'] ? BackendUtility\BackendUtility::getRecordsByField('tx_ecompc_domain_model_package', '1', '1', 'AND NOT tx_ecompc_domain_model_package.deleted AND tx_ecompc_domain_model_package.sys_language_uid IN (-1,0) AND uid IN (' . $ttContent['tx_ecompc_packages'] . ')') : NULL;

		// Fill items Array manually
		$selItems = $this->initItemArray($PA['fieldConf']);
		$rowIndex = count($selItems);

		if ( $configurationPackages instanceof \ArrayAccess || is_array($configurationPackages) ) {
			foreach ( $configurationPackages as $configurationPackage ) {
				$selItems[] = [
					$configurationPackage['backend_label'] ?: $configurationPackage['frontend_label'],
					'--div--'
				];
				if ( $configurationOptions = BackendUtility\BackendUtility::getRecordsByField('tx_ecompc_domain_model_option', 'configuration_package', $configurationPackage['uid'], 'AND NOT deleted AND sys_language_uid IN (-1,0) ORDER BY tx_ecompc_domain_model_option.sorting') ) {
					foreach ( $configurationOptions as $configurationOption ) {
						$addItem = [
							$this->getLabelForTableOption($configurationOption),
							$configurationOption['uid'], 'clear.gif',
							'',
							'',
							$rowIndex,
							'radio'
						];
						if ( $configurationPackage['multiple_select'] ) {
							$addItem[6] = 'checkbox';
							$rowIndex++;
						}
						$selItems[] = $addItem;
					}
					$rowIndex++;
				}
			}
		}
		if ( empty($selItems) ) {
			return '';
		}
		// Get values in an array (and make unique, which is fine because there can be no duplicates anyway):
		$itemArray = array_flip($this->extractValuesOnlyFromValueLabelList($PA['itemFormElValue']));
		$item = '';
		$disabled = '';
		if ( $this->renderReadonly || $config['readOnly'] ) {
			$disabled = ' disabled="disabled"';
		}
		// Traverse the Array of selector box items:
		$tRows = [ ];
		$c = 0;
		if ( !$disabled ) {
			$sOnChange = implode('', $PA['fieldChangeFunc']);
			// Used to accumulate the JS needed to restore the original selection.
			$setAll = [ ];
			$unSetAll = [ ];
			foreach ( $selItems as $p ) {
				// Non-selectable element:
				if ( $p[1] === '--div--' ) {
					$selIcon = '';
					if ( isset($p[2]) && $p[2] != 'empty-emtpy' ) {
						$selIcon = $this->getIconHtml($p[2]);
					}
					$tRows[] = '<tr class="c-header"><td colspan="3">' . $selIcon . htmlspecialchars($p[0]) . '</td></tr>';
				} else {
					// Selected or not by default:
					$sM = '';
					if ( isset($itemArray[$p[1]]) ) {
						$sM = ' checked="checked"';
						unset($itemArray[$p[1]]);
					}
					// Icon:
					if ( $p[2] ) {
						$selIcon = $p[2];
					} else {
						$selIcon = BackendUtility\IconUtility::getSpriteIcon('empty-empty');
					}
					// Compile row:
					$rowId = uniqid('select_checkbox_row_');
					$onClickCell = $p[6] === 'radio' ? '' : $this->elName($PA['itemFormElName'] . '[' . $p[5] . ']') . '.checked=!' . $this->elName($PA['itemFormElName'] . '[' . $p[5] . ']') . '.checked;';
					$onClick = $p[6] === 'radio' ? '' : 'this.attributes.getNamedItem("class").nodeValue = ' . $this->elName(($PA['itemFormElName'] . '[' . $p[5] . ']')) . '.checked ? "c-selectedItem" : "c-unselectedItem";';
					$setAll[] = $this->elName($PA['itemFormElName'] . '[' . $p[5] . ']') . '.checked=1;';
					$setAll[] .= '$(\'' . $rowId . '\').removeClassName(\'c-unselectedItem\');$(\'' . $rowId . '\').addClassName(\'c-selectedItem\');';
					$unSetAll[] = $this->elName($PA['itemFormElName'] . '[' . $p[5] . ']') . '.checked=0;';
					$unSetAll[] .= '$(\'' . $rowId . '\').removeClassName(\'c-selectedItem\');$(\'' . $rowId . '\').addClassName(\'c-unselectedItem\');';
//					$restoreCmd[] = $this->elName($PA['itemFormElName'] . '[' . $p[5] . ']') . '.checked=' . ($sM ? 1 : 0) . ';' . '$(\'' . $rowId . '\').removeClassName(\'c-selectedItem\');$(\'' . $rowId . '\').removeClassName(\'c-unselectedItem\');' . '$(\'' . $rowId . '\').addClassName(\'c-' . ($sM ? '' : 'un') . 'selectedItem\');';
					// Check if some help text is available
					// Since TYPO3 4.5 help text is expected to be an associative array
					// with two key, "title" and "description"
					// For the sake of backwards compatibility, we test if the help text
					// is a string and use it as a description (this could happen if items
					// are modified with an itemProcFunc)
					$hasHelp = FALSE;
					$help = '';
					$helpArray = [ ];
					if ( is_array($p[3]) && count($p[3]) > 0 || !empty($p[3]) ) {
						$hasHelp = TRUE;
						if ( is_array($p[3]) ) {
							$helpArray = $p[3];
						} else {
							$helpArray['description'] = $p[3];
						}
					}
					$label = htmlspecialchars($p[0], ENT_COMPAT, 'UTF-8', false);
					if ( $hasHelp ) {
						$help = BackendUtility\BackendUtility::wrapInHelp('', '', '', $helpArray);
					}
					$tRows[] = '
					<tr id="' . $rowId . '" class="c-unselectedItem" onclick="' . htmlspecialchars($onClick) . '" style="cursor: pointer;">
						<td class="c-checkbox"><input type="' . $p[6] . '"' . (version_compare(TYPO3_branch, '7', '<') ? $this->insertDefStyle('check') : '') . ' name="' . htmlspecialchars(($PA['itemFormElName'] . '[' . $p[5] . ']')) . '" value="' . htmlspecialchars($p[1]) . '"' . $sM . ' onclick="' . htmlspecialchars($sOnChange) . '"' . $PA['onFocus'] . ' id="' . $rowId . '" /></td>
						<td class="c-labelCell" onclick="' . htmlspecialchars($onClickCell) . '">' . (version_compare(TYPO3_branch, '7', '<') ? $this->getIconHtml($selIcon) : \TYPO3\CMS\Backend\Form\Utility\FormEngineUtility::getIconHtml($selIcon)) . $label . '</td>
							<td class="c-descr" onclick="' . htmlspecialchars($onClickCell) . '">' . (empty($help) ? '' : $help) . '</td>
					</tr>';
					$c++;
				}
			}
		}
		// Remaining values (invalid):
		if ( count($itemArray) && !$PA['fieldTSConfig']['disableNoMatchingValueElement'] && !$config['disableNoMatchingValueElement'] ) {
			foreach ( $itemArray as $theNoMatchValue => $temp ) {
				// Compile <checkboxes> tag:
				array_unshift($tRows, '
					<tr class="c-invalidItem">
						<td class="c-checkbox"><input type="checkbox"' . (version_compare(TYPO3_branch, '7', '<') ? $this->insertDefStyle('check') : '') . ' name="' . htmlspecialchars(($PA['itemFormElName'] . '[' . $c . ']')) . '" value="' . htmlspecialchars($theNoMatchValue) . '" checked="checked" onclick="' . htmlspecialchars($sOnChange) . '"' . $PA['onFocus'] . $disabled . ' /></td>
						<td class="c-labelCell">' . htmlspecialchars(@sprintf($nMV_label, $theNoMatchValue), ENT_COMPAT, 'UTF-8', false) . '</td><td>&nbsp;</td>
					</tr>');
				$c++;
			}
		}
		// Add an empty hidden field which will send a blank value if all items are unselected.
		$item .= '<input type="hidden" class="select-checkbox" name="' . htmlspecialchars($PA['itemFormElName']) . '" value="" />';
		// Remaining checkboxes will get their set-all link:
		$tableHead = '<thead>
			<tr class="c-header-checkbox-controls t3-row-header">
				<td class="c-labelCell" style="padding: 5px 10px; text-align: center;" colspan="3"><b>' . $this->getLanguageService()->sL('LLL:EXT:ecompc/Resources/Private/Language/locallang_db.xlf:info.select') . '</b></td>
			</tr></thead>';
		// Implode rows in table:
		$item .= '
		<table border="0" cellpadding="0" cellspacing="0" class="typo3-TCEforms-select-checkbox">' . $tableHead . '<tbody>' . implode('', $tRows) . '</tbody>
		</table>
		';
//		// Add revert icon
//		if ( is_array($restoreCmd) ) {
//			$item .= '<a href="#" onclick="' . implode('', $restoreCmd) . ' return false;' . '">' . BackendUtility\IconUtility::getSpriteIcon('actions-edit-undo', array('title' => htmlspecialchars($this->getLL('l_revertSelection')))) . '</a>';
//		}
		return $item;
	}

	/**
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function userFuncTxEcompcDomainModelOptionPricePercental(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		$package = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('tx_ecompc_domain_model_package', $PA['row']['configuration_package']);
		$PA['fieldConf']['config']['readOnly'] = $package['multiple_select'];

		// Re-render field based on the "true field type", and not as a "user"
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['type'];
		return $pObj->getSingleField_SW($PA['table'], $PA['field'], $PA['row'], $PA);
	}

	/**
	 * getPricingFlexForm function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return string
	 */
	public function getPricingFlexForm(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		if ( $rows = $pObj->getDatabaseConnection()->exec_SELECTgetRows('*', 'tx_ecompc_domain_model_currency', '1=1 ' . BackendUtility\BackendUtility::BEenableFields('tx_ecompc_domain_model_currency')) ) {
			$ds = [
				'meta' => [
					'langDisable' => 1
				],
				'ROOT' => [
					'type' => 'array',
					'el' => [ ]
				]
			];
			foreach ( $rows as $row ) {
				$ds['ROOT']['el'][\TYPO3\CMS\Core\Utility\GeneralUtility::strtolower($row['iso_4217'])] = [
					'TCEforms' => [
						'label' => $row['label'] . ($row['default_currency'] ? ' [default]' : ''),
						'config' => [
							'type' => 'input',
							'size' => 22,
							'eval' => 'double2',
							'default' => '0.00'
						]
					]
				];
			}
			$PA['fieldConf']['config']['ds']['default'] = \TYPO3\CMS\Core\Utility\GeneralUtility::array2xml($ds, '', 0, 'T3DataStructure');
		}

		// Re-render field based on the "true field type", and not as a "user"
		$PA['fieldConf']['config']['form_type'] = $PA['fieldConf']['config']['type'];
		return $pObj->getSingleField_SW($PA['table'], $PA['field'], $PA['row'], $PA);
	}

	/**
	 * itemsProcFuncTxEcompcDomainModelDependencyOptions function.
	 *
	 * @param array                                                                       $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine|\TYPO3\CMS\Backend\Form\DataPreprocessor $pObj
	 *
	 * @return void
	 */
	function itemsProcFuncTxEcompcDomainModelDependencyOptions(array &$PA, $pObj = NULL)  {
		// Adding an item!
		//$PA['items'][] = array($pObj->sL('Added label by PHP function|Tilfjet Dansk tekst med PHP funktion'), 999);

		if ( sizeof($PA['items']) && $PA['row']['packages'] ) {
			$configurationPackages = [ ];
			$referringOption = BackendUtility\BackendUtility::getRecord('tx_ecompc_domain_model_option', $PA['row']['ref_option'], 'pid,configuration_package');

			$packages = array_map('intval', CoreUtility\GeneralUtility::trimExplode(',', $PA['row']['packages']));

			foreach ( $PA['items'] as $item ) {
				$data = BackendUtility\BackendUtility::getRecord('tx_ecompc_domain_model_option', $item[1], '*');
				if ( !sizeof($data) || $data['pid'] !== $referringOption['pid'] || !CoreUtility\GeneralUtility::inList(implode(',', $packages), $data['configuration_package']) ) {
					continue;
				}

				$item[2] = 'clear.gif';
				$configurationPackages[0]['label'] = '-- not assigned --';
				if ( CoreUtility\MathUtility::canBeInterpretedAsInteger($data['configuration_package']) ) {
					if ( !array_key_exists($data['configuration_package'], $configurationPackages) ) {
						$configurationPackageLabels = BackendUtility\BackendUtility::getRecord('tx_ecompc_domain_model_package', $data['configuration_package'], 'frontend_label, backend_label');
						$configurationPackages[$data['configuration_package']]['label'] = $configurationPackageLabels['backend_label'] ? $configurationPackageLabels['backend_label'] : $configurationPackageLabels['frontend_label'];
					}
					$configurationPackages[$data['configuration_package']]['items'][] = $item;
				} else {
					$configurationPackages[0]['items'][] = $item;
				}

			}
			//usort($configurationPackages, 'self::cmp'); // Sort Alphabetically @package label
			ksort($configurationPackages); // Order by uid @package

			$PA['items'] = [ ];
			foreach ( $configurationPackages as $configurationPackage ) {
				if ( !is_array($configurationPackage['items']) ) {
					continue;
				}
				$PA['items'][] = [
					$configurationPackage['label'],
					'--div--'
				];
				$PA['items'] = array_merge($PA['items'], $configurationPackage['items']);
			}
		} elseif ( !$PA['row']['packages'] ) {
			$PA['items'] = [ ];
		}

		// No return - the $PA and $pObj variables are passed by reference, so just change content in then and it is passed back automatically...
	}

	/**
	 * itemsProcFuncTxEcompcDomainModelDependencyNoteDependentOptions function.
	 *
	 * @param array                                                                       $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine|\TYPO3\CMS\Backend\Form\DataPreprocessor $pObj
	 *
	 * @return void
	 */
	function itemsProcFuncTxEcompcDomainModelDependencyNoteDependentOptions(array &$PA, $pObj = NULL)  {
		// Adding an item!
		//$PA['items'][] = array($pObj->sL('Added label by PHP function|Tilfjet Dansk tekst med PHP funktion'), 999);

		if ( sizeof($PA['items']) ) {
			$configurationPackages = [ ];
			$referringPackage = BackendUtility\BackendUtility::getRecord('tx_ecompc_domain_model_package', $PA['row']['ref_package'], 'pid, sorting');

			foreach ( $PA['items'] as $item ) {
				$data = BackendUtility\BackendUtility::getRecord('tx_ecompc_domain_model_option', $item[1], '*');
				$package = BackendUtility\BackendUtility::getRecord('tx_ecompc_domain_model_package', $data['configuration_package'], 'frontend_label, backend_label, sorting, visible_in_frontend');
				if ( !sizeof($data) || $data['pid'] !== $referringPackage['pid'] || $package['sorting'] >= $referringPackage['sorting'] || !$package['visible_in_frontend'] ) {
					continue;
				}

				$item[2] = 'clear.gif';
				$configurationPackages[0]['label'] = '-- not assigned --';
				if ( CoreUtility\MathUtility::canBeInterpretedAsInteger($data['configuration_package']) ) {
					if ( !array_key_exists($data['configuration_package'], $configurationPackages) ) {
						$configurationPackages[$data['configuration_package']]['label'] = $package['backend_label'] ? $package['backend_label'] : $package['frontend_label'];
					}
					$configurationPackages[$data['configuration_package']]['items'][] = $item;
				} else {
					$configurationPackages[0]['items'][] = $item;
				}

			}
			//usort($configurationPackages, 'self::cmp'); // Sort Alphabetically @package label
			ksort($configurationPackages); // Order by uid @package

			$PA['items'] = [ ];
			foreach ( $configurationPackages as $configurationPackage ) {
				if ( !is_array($configurationPackage['items']) ) {
					continue;
				}
				$PA['items'][] = [
					$configurationPackage['label'],
					'--div--'
				];
				$PA['items'] = array_merge($PA['items'], $configurationPackage['items']);
			}
		} elseif ( !$PA['row']['packages'] ) {
			$PA['items'] = [ ];
		}

		// No return - the $PA and $pObj variables are passed by reference, so just change content in then and it is passed back automatically...
	}

	/**
	 * labelUserFuncTxEcompcDomainModelOption function.
	 *
	 * @param array                              $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 *
	 * @return void
	 */
	public function labelUserFuncTxEcompcDomainModelOption(array &$PA, \TYPO3\CMS\Backend\Form\FormEngine $pObj = NULL) {
		$PA['title'] = $this->getLabelForTableOption($PA['row']);
	}

	/**
	 * getLabelForTableOption function.
	 *
	 * @param array $record
	 *
	 * @return string
	 */
	public function getLabelForTableOption(array $record) {
		return ($record['backend_label'] ?: $record['frontend_label']) . (strlen($record['configuration_code_segment']) ? ' »' . $record['configuration_code_segment'] . '«' : '');
	}

	/**
	 * cmp function.
	 * @abstract Used for array function usort()! ATTENTION: key for comparison is hard-coded!!!
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	final public function cmp($a, $b) {
		return strcmp($a['label'], $b['label']);
	}

}

?>