<?php
/**
 * Created by PhpStorm.
 * User: hj
 * Date: 2018/8/20
 * Time: 17:43
 */

/**
 * @api
 * @author liaoyuehuan <1309893442@qq.com>
 * @copyright 版权信息
 * @example  http://example.com/foo.phps
 * @internal
 * @license http://www.spdx.org/licenses/MIT MIT License
 *
 * @method string getString()
 * @method void setInteger(int $integer)
 * @method setString(int $integer)
 *
 * @param int $a description
 * @param array $options {
 * @var bool $required Whether this element is required
 * @var string $content The display name for this element
 * }
 * @return string return string
 * @see http://example.com/my/bar Documentation of Foo.
 * @since 7.1 the method must be required PHP 7.1+
 */
function doc($a, $options = array())
{
    return 'yes';
}