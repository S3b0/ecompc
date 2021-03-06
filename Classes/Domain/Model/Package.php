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
 * Class Package
 * @package S3b0\Ecompc\Domain\Model
 */
class Package extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var int
	 */
	protected $sorting = 0;

	/**
	 * @var int
	 */
	protected $sortingInCode = 0;

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
	protected $prompt = '';

	/**
	 * @var string
	 */
	protected $hintText = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\DependencyNote>
	 */
	protected $dependencyNotes = NULL;

	/**
	 * @var array
	 */
	protected $dependencyNotesFluidParsedMessage = [ ];

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $icon = NULL;

	/**
	 * @var bool
	 */
	protected $visibleInFrontend = FALSE;

	/**
	 * @var int
	 */
	protected $visibility = 3;

	/**
	 * @var bool
	 */
	protected $percentPricing = FALSE;

	/**
	 * @var bool
	 */
	protected $multipleSelect = FALSE;

	/**
	 * @var bool
	 */
	protected $active = FALSE;

	/**
	 * @var bool
	 */
	protected $current = FALSE;

	/**
	 * @var float
	 */
	protected $priceOutput = 0.0;

	/**
	 * @var array
	 */
	protected $activeOptions = array();

	/**
	 * @var \S3b0\Ecompc\Domain\Model\Option
	 */
	protected $defaultOption = NULL;

	/**
	 * @var bool
	 */
	protected $anyOptionActive = FALSE;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Option>
	 */
	protected $options = NULL;

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
		$this->options         = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->dependencyNotes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * @return int
	 */
	public function getSortingInCode() {
		return $this->sortingInCode;
	}

	/**
	 * @param int $sortingInCode
	 */
	public function setSortingInCode($sortingInCode) {
		$this->sortingInCode = $sortingInCode;
	}

	/**
	 * @return string
	 */
	public function getBackendLabel() {
		return $this->backendLabel;
	}

	/**
	 * @param string $backendLabel
	 */
	public function setBackendLabel($backendLabel) {
		$this->backendLabel = $backendLabel;
	}

	/**
	 * @return string
	 */
	public function getFrontendLabel() {
		return $this->frontendLabel;
	}

	/**
	 * @param string $frontendLabel
	 */
	public function setFrontendLabel($frontendLabel) {
		$this->frontendLabel = $frontendLabel;
	}

	/**
	 * @return string
	 */
	public function getPrompt() {
		return $this->prompt;
	}

	/**
	 * @param string $prompt
	 */
	public function setPrompt($prompt) {
		$this->prompt = $prompt;
	}

	/**
	 * @return string
	 */
	public function getHintText() {
		return $this->hintText;
	}

	/**
	 * @param string $hintText
	 */
	public function setHintText($hintText) {
		$this->hintText = $hintText;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DependencyNote>
	 */
	public function getDependencyNotes() {
		return $this->dependencyNotes;
	}

	/**
	 * @return string
	 */
	public function getDependencyNotesFluidParsedMessage() {
		return implode('<br />', $this->dependencyNotesFluidParsedMessage);
	}

	/**
	 * @param string $dependencyNotesFluidParsedMessage
	 */
	public function addDependencyNotesFluidParsedMessage($dependencyNotesFluidParsedMessage) {
		$this->dependencyNotesFluidParsedMessage[] = $dependencyNotesFluidParsedMessage;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
	 */
	public function setIcon(\TYPO3\CMS\Extbase\Domain\Model\FileReference $icon) {
		$this->icon = $icon;
	}

	/**
	 * @return bool
	 */
	public function isVisibleInFrontend() {
		return $this->visibleInFrontend;
	}

	/**
	 * @param bool $visibleInFrontend
	 */
	public function setVisibleInFrontend($visibleInFrontend) {
		$this->visibleInFrontend = $visibleInFrontend;
	}

	/**
	 * @return int
	 */
	public function getVisibility() {
		return $this->visibility;
	}

	/**
	 * @param int $visibility
	 */
	public function setVisibility($visibility) {
		$this->visibility = $visibility;
	}

	/**
	 * @return bool
	 */
	public function isVisibleInSummary() {
		return (bool) ($this->visibility & 1);
	}

	/**
	 * @return bool
	 */
	public function isVisibleInNavigation() {
		return (bool) ($this->visibility & 2);
	}

	/**
	 * @return bool
	 */
	public function isPercentPricing() {
		return $this->isMultipleSelect() ? FALSE : $this->percentPricing;
	}

	/**
	 * @param bool $percentPricing
	 */
	public function setPercentPricing($percentPricing) {
		$this->percentPricing = $this->multipleSelect ? FALSE : $percentPricing;
	}

	/**
	 * @return bool
	 */
	public function isMultipleSelect() {
		return $this->multipleSelect;
	}

	/**
	 * @param bool $multipleSelect
	 */
	public function setMultipleSelect($multipleSelect) {
		$this->multipleSelect = $multipleSelect;
	}

	/**
	 * @return bool
	 */
	public function isActive() {
		return $this->active;
	}

	/**
	 * @param bool $active
	 */
	public function setActive($active) {
		$this->active = $active;
	}

	/**
	 * @return bool
	 */
	public function isCurrent() {
		return $this->current;
	}

	/**
	 * @param bool $current
	 */
	public function setCurrent($current) {
		$this->current = $current;
	}

	/**
	 * @return float
	 */
	public function getPriceOutput() {
		return $this->priceOutput;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $options
	 * @param \S3b0\Ecompc\Domain\Model\Currency $currency
	 */
	public function setPriceOutput(\TYPO3\CMS\Extbase\Persistence\QueryResultInterface $options = NULL, \S3b0\Ecompc\Domain\Model\Currency $currency) {
		$priceOutput = 0.0;
		if ( $options instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface && $options->count() ) {
			/** @var \S3b0\Ecompc\Domain\Model\Option $option */
			foreach ( $options as $option ) {
				$priceOutput += $option->getPricing($currency);
			}
		}

		$this->priceOutput = $priceOutput;
	}

	/**
	 * @return \S3b0\Ecompc\Domain\Model\Option
	 */
	public function getDefaultOption() {
		return $this->defaultOption;
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Option $defaultOption
	 */
	public function setDefaultOption(\S3b0\Ecompc\Domain\Model\Option $defaultOption) {
		$this->defaultOption = $defaultOption;
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Option $option
	 */
	public function addOption(\S3b0\Ecompc\Domain\Model\Option $option) {
		if ( $this->options === NULL ) {
			$this->options = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		}

		/** Avoid duplicates */
		if ( !$this->options->contains($option) ) {
			$this->options->attach($option);
		}
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Option $optionToRemove
	 */
	public function removeOption(\S3b0\Ecompc\Domain\Model\Option $optionToRemove) {
		$this->options->detach($optionToRemove);
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getOptions() {
		if ( $this->options === NULL ) {
			$this->options = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		}

		return \S3b0\Ecompc\Utility\ObjectStorageSortingUtility::sortByProperty('sorting', $this->options);
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Option> $options
	 */
	public function setOptions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $options = NULL) {
		$this->options = $options;
	}

	/**
	 * @return array
	 */
	public function getActiveOptions() {
		return $this->activeOptions;
	}

	/**
	 * @param array $activeOptions
	 */
	public function setActiveOptions(array $activeOptions) {
		$this->activeOptions = $activeOptions;

		if ( count($activeOptions) ) {
			$this->setAnyOptionActive(TRUE);
		}
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Option $option
	 */
	public function addActiveOption(\S3b0\Ecompc\Domain\Model\Option $option) {
		$this->activeOptions = array_merge($this->getActiveOptions(), array($option->getUid()));
		$this->setAnyOptionActive(TRUE);
	}

	/**
	 * @param \S3b0\Ecompc\Domain\Model\Option $option
	 */
	public function removeActiveOption(\S3b0\Ecompc\Domain\Model\Option $option) {
		$this->activeOptions = array_diff($this->getActiveOptions(), array($option->getUid()));
	}

	/**
	 * @return bool
	 */
	public function hasActiveOptions() {
		return (bool) count($this->activeOptions);
	}

	/**
	 * @return bool
	 */
	public function isAnyOptionActive() {
		return $this->anyOptionActive;
	}

	/**
	 * @param bool $anyOptionActive
	 */
	public function setAnyOptionActive($anyOptionActive) {
		$this->anyOptionActive = $anyOptionActive;
	}

	/**
	 * @return array
	 */
	public function getSummaryForJSONView() {
		return [
			'uid' => $this->getUid(),
			'state' => (bool) $this->hasActiveOptions(),
			'multiple' => $this->isMultipleSelect(),
			'title' => $this->getFrontendLabel(),
			'icon' => $this->getIcon() ? $this->getIcon()->getOriginalResource()->getUid() : 0,
			'hint' => $this->getHintText()
		];
	}

}