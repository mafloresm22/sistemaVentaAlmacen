<?php

namespace App\Helpers;

class Helper
{
    /**
     * Update the page config from the blade view and return a JS snippet
     * that merges the given options into the global templateCustomizer / config object.
     *
     * @param  array  $pageConfigs
     * @return string
     */
    public static function updatePageConfig(array $pageConfigs): string
    {
        $configs = json_encode($pageConfigs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return "<script>
  // Page configs (injected by Helper::updatePageConfig)
  window.templateCustomizer = window.templateCustomizer || {};
  window.templateCustomizer.settings = Object.assign(
    window.templateCustomizer.settings || {},
    {$configs}
  );
</script>";
    }
}
