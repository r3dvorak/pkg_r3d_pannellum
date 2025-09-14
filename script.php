<?php
/**
 * @package     Joomla.Package
 * @subpackage  pkg_r3d_pannellum
 * @creation    2025-09-04
 * @author      Richard Dvorak, r3d.de
 * @copyright   Copyright (C) 2025 Richard Dvorak, https://r3d.de
 * @license     GNU GPL v3 or later (https://www.gnu.org/licenses/gpl-3.0.html)
 * @version     5.0.8
 * @file        packages/pkg_r3d_pannellum/script.php
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

/**
 * Package installer script to finalize install.
 */
final class pkg_r3d_pannellumInstallerScript
{
    /**
     * Auto-enable the system plugin r3d_adminui after installation/update.
     *
     * @param string $type
     * @param object $parent
     * @return void
     */
    public function postflight($type, $parent): void
    {
        $db = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__extensions'))
            ->set($db->quoteName('enabled') . ' = 1')
            ->where($db->quoteName('type') . ' = ' . $db->quote('plugin'))
            ->where($db->quoteName('element') . ' = ' . $db->quote('r3d_adminui'))
            ->where($db->quoteName('folder') . ' = ' . $db->quote('system'));

        try {
            $db->setQuery($query)->execute();
        } catch (\Throwable $e) {
            // Don't hard-fail the package installation if this toggle fails
        }
    }
}
