<?php
namespace S3b0\Ecompc\Domain\Model;


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

/**
 * Class Option
 *
 * @package S3b0\Ecompc\Domain\Model
 */
class Option extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var integer
	 */
	protected $sorting = 0;

	/**
	 * @var string
	 */
	protected $backendLabel = '';

	/**
	 * @var string
	 */
	protected $frontendLabel = '';

	/**
	 * @var string
	 */
	protected $configurationCodeSegment = '';

	/**
	 * @var boolean
	 */
	protected $configurationCodeSegmentSet = FALSE;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $image = NULL;

	/**
	 * @var string
	 */
	protected $hintText = '';

	/**
	 * @var float
	 */
	protected $price = 0.0;

	/**
	 * @var float
	 */
	protected $unitPrice = 0.0;

	/**
	 * @var float
	 */
	protected $pricePercental = 0.0;

	/**
	 * @var string
	 */
	protected $pricing = '';

	/**
	 * @var float
	 */
	protected $priceOutput = 0.0;

	/**
	 * @var \S3b0\Ecompc\Domain\Model\Package
	 */
	protected $configurationPackage = NULL;

	/**
	 * @var \S3b0\Ecompc\Domain\Model\Dependency
	 */
	protected $dependency = NULL;

	/**
	 * @var boolean
	 */
	protected $active = FALSE;

	/**
	 * @var boolean
	 */
	protected $inConflictWithSelectedOptions = TRUE;

	/**
	 * @var boolean
	 */
	protected $disabled = FALSE;

	/**
	 * @return integer
	 */
	public function getSorting() {
		return $this->sorting;
	}

	/**
	 * @param integer $sorting
	 */
	public function setSorting($sorting) {
		$this->sorting = $sorting;
	}

	/**
	 * @return string $backendLabel
	 */
	public function getBackendLabel() {
		return $this->backendLabel;
	}

	/**
	 * @param string $backendLabel
	 * @return void
	 */
	public function setBackendLabel($backendLabel) {
		$this->backendLabel = $backendLabel;
	}

	/**
	 * @return string $frontendLabel
	 */
	public function getFrontendLabel() {
		return $this->frontendLabel;
	}

	/**
	 * @param string $frontendLabel
	 * @return void
	 */
	public function setFrontendLabel($frontendLabel) {
		$this->frontendLabel = $frontendLabel;
	}

	/**
	 * @return string $configurationCodeSegment
	 */
	public function getConfigurationCodeSegment() {
		return $this->configurationCodeSegment;
	}

	/**
	 * @param string $configurationCodeSegment
	 * @return void
	 */
	public function setConfigurationCodeSegment($configurationCodeSegment) {
		$this->configurationCodeSegment = $configurationCodeSegment;
	}

	/**
	 * @return boolean
	 */
	public function isConfigurationCodeSegmentSet() {
		return (bool) strlen($this->getConfigurationCodeSegment());
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 * @return void
	 */
	public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
		$this->image = $image;
	}

	/**
	 * @return string $hintText
	 */
	public function getHintText() {
		return $this->hintText;
	}

	/**
	 * @param string $hintText
	 * @return void
	 */
	public function setHintText($hintText) {
		$this->hintText = $hintText;
	}

	/**
	 * @return boolean
	 */
	public function hasHintText() {
		return (bool) strlen($this->hintText);
	}

	/**
	 * @return float $price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @param float $price
	 * @return void
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * @return float
	 */
	public function getUnitPrice() {
		return $this->unitPrice;
	}

	/**
	 * @param float $unitPrice
	 * @return void
	 */
	public function setUnitPrice($unitPrice) {
		$this->unitPrice = $unitPrice;
	}

	/**
	 * @return float $pricePercental
	 */
	public function getPricePercental() {
		return $this->pricePercental / 100;
	}

	/**
	 * @param float $pricePercental
	 * @return void
	 */
	public function setPricePercental($pricePercental) {
		$this->pricePercental = $pricePercental;
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Currency $currency
	 * @param float                              $configurationPrice
	 *
	 * @return float
	 */
	public function getPricing(\S3b0\Ecompc\Domain\Model\Currency $currency = NULL, $configurationPrice = 0.0) {
		if ( !$currency instanceof \S3b0\Ecompc\Domain\Model\Currency )
			return 0.0;

		/**
		 * Return percental pricing if set.
		 * In this case currency does not mind since configuration price is crucial.
		 */
		if ( $this->getConfigurationPackage()->isPercentPricing() ) {
			return $configurationPrice * $this->getPricePercental();
		}

		/** @var \TYPO3\CMS\Extbase\Service\FlexFormService $flexFormService */
		$flexFormService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Service\\FlexFormService');
		$convertedArray = $flexFormService->convertFlexFormContentToArray($this->pricing);
		$price = $convertedArray[\TYPO3\CMS\Core\Utility\GeneralUtility::strtolower($currency->getIso4217())];

		/**
		 * Return default currency value
		 */
		if ( $currency->isDefaultCurrency() ) {
			return floatval($price) ?: $this->getPrice();
		}

		/**
		 * Return other currency value, if set
		 */
		if ( $price > 0 ) {
			return floatval($price);
		}

		/**
		 * calculate on exchange base!
		 */
		/** @var \TYPO3\CMS\Core\Database\DatabaseConnection $db */
		$db = $GLOBALS['TYPO3_DB'];
		$default = $db->exec_SELECTgetSingleRow('iso_4217', 'tx_ecompc_domain_model_currency', 'tx_ecompc_domain_model_currency.settings & ' . \S3b0\Ecompc\Utility\Div::BIT_CURRENCY_IS_DEFAULT . \TYPO3\CMS\Backend\Utility\BackendUtility::BEenableFields('tx_ecompc_domain_model_currency'));
		$defaultPrice = floatval($convertedArray[\TYPO3\CMS\Core\Utility\GeneralUtility::strtolower($default['iso_4217'])]) ?: $this->getPrice();
		if ( $defaultPrice && $currency->getExchange() ) {
			return floatval($defaultPrice * $currency->getExchange());
		}

		return 0.0;

	}

	/**
	 * @param string $pricing
	 * @return void
	 */
	public function setPricing($pricing) {
		$this->pricing = $pricing;
	}

	/**
	 * @return float $priceOutput
	 */
	public function getPriceOutput() {
		return $this->priceOutput;
	}

	/**
	 * @param float $priceOutput
	 * @return void
	 */
	public function setPriceOutput($priceOutput) {
		$this->priceOutput = $priceOutput;
	}

	/**
	 * @return \S3b0\Ecompc\Domain\Model\Package $configurationPackage
	 */
	public function getConfigurationPackage() {
		return $this->configurationPackage;
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Package $configurationPackage
	 * @return void
	 */
	public function setConfigurationPackage(\S3b0\Ecompc\Domain\Model\Package $configurationPackage) {
		$this->configurationPackage = $configurationPackage;
	}

	/**
	 * @return \S3b0\Ecompc\Domain\Model\Dependency $dependency
	 */
	public function getDependency() {
		return $this->dependency;
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Dependency $dependency
	 * @return void
	 */
	public function setDependency(\S3b0\Ecompc\Domain\Model\Dependency $dependency) {
		$this->dependency = $dependency;
	}

	/**
	 * @return boolean
	 */
	public function isActive() {
		return $this->active;
	}

	/**
	 * @param boolean $active
	 * @return void
	 */
	public function setActive($active) {
		$this->active = $active;
	}

	/**
	 * @return boolean
	 */
	public function isDisabled() {
		return $this->disabled;
	}

	/**
	 * @param boolean $disabled
	 */
	public function setDisabled($disabled) {
		$this->disabled = $disabled;
	}

	/**
	 * @return boolean $inConflictWithSelectedOptions
	 */
	public function isInConflictWithSelectedOptions() {
		return $this->inConflictWithSelectedOptions;
	}

	/**
	 * @param boolean                           $inConflictWithSelectedOptions
	 * @param \S3b0\Ecompc\Domain\Model\Package $package
	 * @return void
	 */
	public function setInConflictWithSelectedOptions($inConflictWithSelectedOptions, \S3b0\Ecompc\Domain\Model\Package $package = NULL) {
		$this->inConflictWithSelectedOptions = $inConflictWithSelectedOptions;

		if ( $this->isInConflictWithSelectedOptions() ) {
			$this->setDisabled(TRUE);
			$this->setFrontendLabel($this->frontendLabel . ' • ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('mark_incompatible_options', 'ecompc'));
		}
	}

	/**
	 * @param array                              $selectedOptions
	 * @param boolean                            $includePricing
	 * @param \S3b0\Ecompc\Domain\Model\Currency $currency
	 * @param float                              $configurationPrice
	 *
	 * @return array
	 */
	public function getSummaryForJSONView(array $selectedOptions = array(), $includePricing = FALSE, \S3b0\Ecompc\Domain\Model\Currency $currency = NULL, array $pricing = array()) {
		$returnArray = array(
			'uid' => $this->uid,
			'sorting' => $this->sorting,
			'active' => in_array($this->uid, $selectedOptions),
			'state' => $this->configurationPackage->isActive(),
			'package' => $this->configurationPackage->getUid(),
			'disabled' => $this->disabled,
			'title' => $this->frontendLabel . ($this->isConfigurationCodeSegmentSet() ? ' [' . $this->configurationCodeSegment . ']' : ''),
			'hint' => (bool) strlen($this->hasHintText())
		);

		if ( $includePricing ) {
			$unitPrice = $this->getPricing($currency, $pricing[2]);
			if ( $this->configurationPackage->isMultipleSelect() ) {
				$priceDifference = $this->active ? 0.0 : $unitPrice;
			} else {
				$priceDifference = $this->active ? 0.0 : ($unitPrice - ($pricing[3] - $pricing[2]));
			}
			/** @var \TYPO3\CMS\Fluid\ViewHelpers\S3b0\Financial\CurrencyViewHelper $currencyVH */
			$currencyVH = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\ViewHelpers\\S3b0\\Financial\\CurrencyViewHelper');
			$returnArray['price'] = $currencyVH->render(
				$currency,
				$priceDifference
			) . ' ( ' . $currencyVH->render(
				$currency,
				$unitPrice,
				2,
				FALSE
			) . ($this->configurationPackage->isPercentPricing() ? ' <span style="font-family: \'Lucida Sans Unicode\', Arial, sans-serif">≙</span> ' . ($this->getPricePercental() * 100) . '%' : '') . ' )';
		}

		return $returnArray;
	}

}