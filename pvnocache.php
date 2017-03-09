	<?php
/**
 * @version     $Id: pvnocache.php
 * @package     PVotes
 * @subpackage  Content
 * @copyright   Copyright (C) 2015 Philadelphia Elections Commission
 * @license     GNU/GPL, see LICENSE.php
 * @author      Matthew Murphy <matthew.e.murphy@phila.gov>
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * System Plugin
 *
 * @package     Joomla
 * @subpackage  System
 * @since       1.5
 */
class plgSystemPvnocache extends JPlugin
{

    /**
     * Set cookies JSESSION on front-end if logged in
     * Disable cache if logged in or in back-end
     *
     * @return  void
     *
     * @since   3.0
     */
    public function onAfterInitialise()
    {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        if ($app->isAdmin()) {
            $app->allowCache(false);
        } else if (!$user->guest) {
            $app->allowCache(false);
            if (!$app->input->cookie->get('JSESSION')) {
                $app->input->cookie->set('JSESSION', true);
            }
        } else {
            $app->allowCache(true);
            if ($app->input->cookie->get('JSESSION')) {
                $app->input->cookie->set('JSESSION', NULL, time() - 1);
            }
        }
    }
}
