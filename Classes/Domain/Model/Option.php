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
	 * @var int
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
	 * @var float
	 */
	protected $pricing = 0.0;

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
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Option>
	 */
	protected $conflictsWithSelectedOptions = NULL;

	/**
	 * @var boolean
	 */
	protected $disabled = FALSE;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->conflictsWithSelectedOptions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * @return int
	 */
	public function getSorting() {
		return $this->sorting;
	}

	/**
	 * @param int $sorting
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
	public function hasConfigurationCodeSegment() {
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
	 * @return float $pricing
	 */
	public function getPricing(\S3b0\Ecompc\Domain\Model\Currency $currency = NULL, $configurationPrice = 0.0) {
		if (!$currency instanceof \S3b0\Ecompc\Domain\Model\Currency)
			return 0.0;

		/**
		 * Return percental pricing if set.
		 * In this case currency does not mind since configuration price is crucial.
		 */
		if ($this->getConfigurationPackage()->isPercentPricing()) {
			return $configurationPrice * $this->getPricePercental();
		}

		$convArray = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($this->pricing);
		$flexFormArray = $convArray['data']['sDEF']['lDEF'];
		$price = $flexFormArray[\TYPO3\CMS\Core\Utility\GeneralUtility::strtolower($currency->getIso4217())]['vDEF'];

		/**
		 * Return default currency value
		 */
		if ($currency->isDefaultCurrency()) {
			return floatval($price);
		}

		/**
		 * Return other currency value, if set
		 */
		if ($price > 0) {
			return floatval($price);
		}

		/**
		 * calculate on exchange base!
		 */
		/** @var \TYPO3\CMS\Core\Database\DatabaseConnection $db */
		$db = $GLOBALS['TYPO3_DB'];
		$default = $db->exec_SELECTgetSingleRow('iso_4217', 'tx_ecompc_domain_model_currency', 'tx_ecompc_domain_model_currency.settings & ' . \S3b0\Ecompc\Utility\Div::BIT_CURRENCY_IS_DEFAULT . \TYPO3\CMS\Backend\Utility\BackendUtility::BEenableFields('tx_ecompc_domain_model_currency'));
		$defaultPrice = $flexFormArray[\TYPO3\CMS\Core\Utility\GeneralUtility::strtolower($default['iso_4217'])]['vDEF'];
		if ($defaultPrice && $currency->getExchange()) {
			return floatval($defaultPrice * $currency->getExchange());
		}

		return 0.0;

	}

	/**
	 * @param float $pricing
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
	 * @param \S3b0\Ecompc\Domain\Model\Option $conflictsWithSelectedOption
	 * @return void
	 */
	public function addConflictsWithSelectedOption(\S3b0\Ecompc\Domain\Model\Option $conflictsWithSelectedOption) {
		if ($this->conflictsWithSelectedOptions === NULL) {
			$this->conflictsWithSelectedOptions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		}

		$this->conflictsWithSelectedOptions->attach($conflictsWithSelectedOption);
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Option $conflictsWithSelectedOptionToRemove
	 * @return void
	 */
	public function removeConflictsWithSelectedOption(\S3b0\Ecompc\Domain\Model\Option $conflictsWithSelectedOptionToRemove) {
		$this->conflictsWithSelectedOptions->detach($conflictsWithSelectedOptionToRemove);
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $conflictsWithSelectedOptions
	 */
	public function getConflictsWithSelectedOptions() {
		if ($this->conflictsWithSelectedOptions === NULL) {
			$this->conflictsWithSelectedOptions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		}

		return $this->conflictsWithSelectedOptions;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Option> $conflictsWithSelectedOptions
	 * @return void
	 */
	public function setConflictsWithSelectedOptions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $conflictsWithSelectedOptions = null) {
		$this->conflictsWithSelectedOptions = $conflictsWithSelectedOptions;
	}

	/**
	 * @param array                              $selectedOptions
	 * @param boolean                            $includePricing
	 * @param \S3b0\Ecompc\Domain\Model\Currency $currency
	 *
	 * @return array
	 */
	public function getSummaryForJSONView(array $selectedOptions = array(), $includePricing = FALSE, \S3b0\Ecompc\Domain\Model\Currency $currency = NULL) {
		$returnArray = array(
			'uid' => $this->getUid(),
			'active' => in_array($this->getUid(), $selectedOptions),
			'state' => $this->getConfigurationPackage()->isActive(),
			'package' => $this->getConfigurationPackage()->getUid(),
			'disabled' => $this->isDisabled(),
			'title' => $this->getFrontendLabel() . ($this->hasConfigurationCodeSegment() ? ' [' . $this->getConfigurationCodeSegment() . ']' : ''),
			'hint' => (bool) strlen($this->getHintText())
		);

		if ($includePricing) {
			/** @var \TYPO3\CMS\Fluid\ViewHelpers\S3b0\Financial\CurrencyViewHelper $currencyVH */
			$currencyVH = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\ViewHelpers\\S3b0\\Financial\\CurrencyViewHelper');
			$returnArray['price'] = $currencyVH->render(
				$this->getPricing($currency),
				$currency->getSymbol(),
				$currency->isSymbolPrepended(),
				$currency->isNumberSeparatorsInUSFormat(),
				$currency->isWhitespaceBetweenCurrencyAndValue()
			);
		}

		return $returnArray;
	}

}