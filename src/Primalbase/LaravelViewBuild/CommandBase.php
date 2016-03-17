<?php namespace Primalbase\LaravelViewBuild;

use Illuminate\Console\Command;
use Config;
use View;

class CommandBase extends Command {

  public function hint()
  {
    return <<<__CONFIG__
'dwt' => [
  'templates_dir' => 'Templates',
],
__CONFIG__;
  }

  public function getConfig()
  {
    return Config::get('laravel-view-build::dwt', []);
  }

  public function getViewPath($view)
  {
    /** @see Illuminate\View\FileViewFinder */
    if (strpos($view, '::') > 0)
    {
      list($namespace, $view) = explode('::', $view);
      $baseDir = head(array_get(View::getFinder()->getHints(), $namespace));
    }
    else
    {
      $baseDir = app_path('views');
    }

    $view = str_replace('.', '/', $view);

    return $baseDir.'/'.$view.'.blade.php';
  }
}