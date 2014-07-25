<?php
/**
 * Created by PhpStorm.
 * User: sebo
 * Date: 17.07.14
 * Time: 09:48
 */

namespace S3b0\Ecompc\Domain\Session;

/**
 * FrontendSessionHandler
 *
 * @package S3b0
 * @subpackage Ecompc
 */
class FrontendSessionHandler extends \S3b0\Ecompc\Domain\Session\SessionHandler {

	/**
	 * @var string
	 */
	protected $mode = "FE";

}