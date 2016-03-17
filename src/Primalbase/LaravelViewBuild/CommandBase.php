<?php namespace Primalbase\LaravelViewBuild;

use Illuminate\Console\Command;
use Config;
use View;

class CommandBase extends Command {

  protected $dwtLayout;

  public function getDwtLayout($source, $outputPath, $layout, $makeBase, $baseView, $style)
  {
    if (!$this->dwtLayout)
    {
      $dwtLayout = new DwtLayout;
      $dwtLayout->setDocumentRoot(public_path());
      $this->dwtLayout = $dwtLayout;
    }

    $this->dwtLayout->setSource($source);
    $this->dwtLayout->setOutputPath($outputPath);
    $this->dwtLayout->setLayout($layout);
    $this->dwtLayout->setEnabledMakeBase($makeBase);
    $this->dwtLayout->setBaseView($baseView);
    $this->dwtLayout->setStyle($style);

    return $this->dwtLayout;
  }

  public function getConfig()
  {
    return Config::get('laravel-view-build::config', []);
  }

  public function getSourcePath($source, $layout = true)
  {
    if ($layout)
    {
      $config = $this->getConfig();
      $templatesDir = array_get($config, 'dwt.templates_dir');
      $sourcePath = $templatesDir.'/'.$source;
    }
    else
    {
      $sourcePath = $source;
    }

    if (!file_exists(public_path($sourcePath)))
    {
      $this->error(public_path($sourcePath).' file not found.');
      return false;
    }

    return $sourcePath;
  }

  public function getViewPath($view, $makeBase = true)
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

    $viewPath = $baseDir.'/'.$view.'.blade.php';

    if (!$makeBase && file_exists($viewPath))
    {
      if (!$this->confirm('file exists. overwrite?[y/N]'))
      {
        $this->info('canceled.');
        return false;
      }
    }

    return $viewPath;
  }

  public function getBaseView($view)
  {
    if (preg_match('/^(.*[\:\.])([^.:]+)$/', $view, $m))
    {
      return $m[1].'base.'.$m[2];
    }
    else
    {
      return 'base.'.$view;
    }
  }
}