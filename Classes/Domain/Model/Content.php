<?php
namespace S3b0\Ecompc\Domain\Model;


/***************************************************************
 * Copyright notice
 *
 * (c) 2012 Klaus Heuer <klaus.heuer@t3-developer.com>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Content
 *
 * @package S3b0
 * @subpackage Ecompc
 */
class Content extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 */
	protected $bodytext;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Page>
	 */
	protected $storage = NULL;

	/**
	 * @var int
	 */
	protected $recursive = 0;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Package>
	 */
	protected $ecompcPackages = NULL;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Configuration>
	 */
	protected $ecompcConfigurations = NULL;

	/**
	 * ecompcBasePriceInDefaultCurrency
	 *
	 * @var float
	 */
	protected $ecompcBasePriceInDefaultCurrency = 0.0;

	/**
	 * ecompcBasePriceInForeignCurrencies
	 *
	 * @var string
	 */
	protected $ecompcBasePriceInForeignCurrencies = '';

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
		$this->storage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->ecompcPackages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->ecompcConfigurations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * @return string $bodytext
	 */
	public function getBodytext() {
		return $this->bodytext;
	}

	/**
	 * Adds a Storage
	 *
	 * @param \S3b0\Ecompc\Domain\Model\Page $page
	 * @return void
	 */
	public function addStorage(\S3b0\Ecompc\Domain\Model\Page $page) {
		$this->storage->attach($page);
	}

	/**
	 * Removes a Storage
	 *
	 * @param \S3b0\Ecompc\Domain\Model\Page $page
	 * @return void
	 */
	public function removeStorage(\S3b0\Ecompc\Domain\Model\Page $page) {
		$this->storage->detach($page);
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Page> $storage
	 */
	public function getStorage() {
		return $this->storage;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Page> $storage
	 */
	public function setStorage($storage) {
		$this->storage = $storage;
	}

	/**
	 * @return int
	 */
	public function getRecursive() {
		return $this->recursive;
	}

	/**
	 * @param int $recursive
	 */
	public function setRecursive($recursive) {
		$this->recursive = $recursive;
	}

	/**
	 * Adds a Package
	 *
	 * @param \S3b0\Ecompc\Domain\Model\Package $package
	 * @return void
	 */
	public function addEcompcPackage(\S3b0\Ecompc\Domain\Model\Package $package) {
		$this->ecompcPackages->attach($package);
	}

	/**
	 * Removes a Package
	 *
	 * @param \S3b0\Ecompc\Domain\Model\Package $package
	 * @return void
	 */
	public function removeEcompcPackage(\S3b0\Ecompc\Domain\Model\Package $package) {
		$this->ecompcPackages->detach($package);
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Package> $ecompcPackages
	 */
	public function getEcompcPackages() {
		return $this->ecompcPackages;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Package> $ecompcPackages
	 * @return void
	 */
	public function setEcompcPackages($ecompcPackages) {
		$this->ecompcPackages = $ecompcPackages;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Package> $ecompcPackages
	 */
	public function getEcompcPackagesFE() {
		if ($this->ecompcPackages === NULL) {
			$this->ecompcPackages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		}
		if ($this->ecompcPackages->count() === 0) {
			return NULL;
		}

		$return = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		/** @var \S3b0\Ecompc\Domain\Model\Package $package */
		foreach ($this->ecompcPackages as $package) {
			if ($package->isVisibleInFrontend())
				$return->attach($package);
		}

		return $return;
	}

	/**
	 * Adds a Configuration
	 *
	 * @param \S3b0\Ecompc\Domain\Model\Configuration $configuration
	 * @return void
	 */
	public function addEcompcConfiguration(\S3b0\Ecompc\Domain\Model\Configuration $configuration) {
		$this->ecompcConfigurations->attach($configuration);
	}

	/**
	 * Removes a Configuration
	 *
	 * @param \S3b0\Ecompc\Domain\Model\Configuration $configuration
	 * @return void
	 */
	public function removeEcompcConfiguration(\S3b0\Ecompc\Domain\Model\Configuration $configuration) {
		$this->ecompcConfigurations->detach($configuration);
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Configuration> $ecompcConfigurations
	 */
	public function getEcompcConfigurations() {
		return $this->ecompcConfigurations;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\S3b0\Ecompc\Domain\Model\Configuration> $ecompcConfigurations
	 */
	public function setEcompcConfigurations($ecompcConfigurations) {
		$this->ecompcConfigurations = $ecompcConfigurations;
	}

	/**
	 * Returns the ecompcBasePriceInDefaultCurrency
	 *
	 * @return float $ecompcBasePriceInDefaultCurrency
	 */
	public function getEcompcBasePriceInDefaultCurrency() {
		return $this->ecompcBasePriceInDefaultCurrency;
	}

	/**
	 * Sets the ecompcBasePriceInDefaultCurrency
	 *
	 * @param float $ecompcBasePriceInDefaultCurrency
	 * @return void
	 */
	public function setEcompcBasePriceInDefaultCurrency($ecompcBasePriceInDefaultCurrency) {
		$this->ecompcBasePriceInDefaultCurrency = $ecompcBasePriceInDefaultCurrency;
	}

	/**
	 * Returns the ecompcBasePriceInForeignCurrencies
	 *
	 * @return string $ecompcBasePriceInForeignCurrencies
	 */
	public function getEcompcBasePriceInForeignCurrencies() {
		$converted2Array = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($this->ecompcBasePriceInForeignCurrencies);
		return $converted2Array['data']['sDEF']['lDEF'];
	}

	/**
	 * Sets the ecompcBasePriceInForeignCurrencies
	 *
	 * @param string $ecompcBasePriceInForeignCurrencies
	 *
*@return void
	 */
	public function setEcompcBasePriceInForeignCurrencies($ecompcBasePriceInForeignCurrencies) {
		$this->ecompcBasePriceInForeignCurrencies = $ecompcBasePriceInForeignCurrencies;
	}

	/**
	 * @param string $currency
	 * @param float  $exchange
	 *
	 * @return float
	 */
	public function getPriceInCurrency($currency = 'default', $exchange = 0.00) {
		if ($currency === 'default')
			return $this->getEcompcBasePriceInDefaultCurrency();

		$foreignCurrencies = $this->getEcompcBasePriceInForeignCurrencies();
		$price = strlen($currency) === 3 && array_key_exists($currency, $foreignCurrencies) ? floatval($foreignCurrencies[$currency]['vDEF']) : 0.00;

		return $price > 0 ? $price : ($this->getEcompcBasePriceInDefaultCurrency() * $exchange);
	}

	/**
	 * @return array
	 */
	public function getStoragePidArray() {
		$pidArray = array();

		if ($this->getStorage() instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage && $this->getStorage()->count()) {
			/** @var \S3b0\Ecompc\Domain\Model\Page $storage */
			foreach ($this->getStorage() as $storage) {
				/** @var \TYPO3\CMS\Frontend\Page\PageRepository $pageRepository */
				$pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
				if ($rootLine = $pageRepository->getRootLine($storage->getUid())) {
					$limit = $this->getRecursive() < count($rootLine) ? $this->getRecursive() + 1 : count($rootLine);
					for ($i = 0; $i < $limit; $i++) {
						$current = current($rootLine);
						$pidArray[] = $current['uid'];
						next($rootLine);
					}
				}
			}
		}

		return array_unique($pidArray);
	}

}