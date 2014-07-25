<?php
/**
 * Created by PhpStorm.
 * User: sebo
 * Date: 17.07.14
 * Time: 09:48
 */

namespace S3b0\Ecompc\Domain\Session;

/**
 * BackendSessionHandler
 *
 * @package S3b0
 * @subpackage Ecompc
 */
class BackendSessionHandler extends \S3b0\Ecompc\Domain\Session\SessionHandler {

	/**
	 * @var string
	 */
	protected $mode = "BE";

}