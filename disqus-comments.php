<?php

namespace Grav\Plugin;

use Grav\Common\Plugin;

/**
 * Class DisqusCommentsPlugin
 * @package Grav\Plugin
 */
class DisqusCommentsPlugin extends Plugin
{
    private $enable;

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return ['onPluginsInitialized' => ['onPluginsInitialized', 0]];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }
        $this->initializeFrontend();
    }

    /**
     * Add templates directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    public function onTwigSiteVariables()
    {
        $this->grav['twig']->disqus_comments_plugin = $this->config->get('plugins.disqus-comments');
    }

    public function initializeFrontend()
    {
        $this->enable = $this->grav['config']->get('plugins.disqus-comments.enabled');
        $this->enable(
            [
                'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
                'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
            ]
        );
    }
}
