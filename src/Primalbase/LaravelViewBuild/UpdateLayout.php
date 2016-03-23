<?php namespace Primalbase\LaravelViewBuild;

class UpdateLayout extends CommandBase {

  protected $name = 'layout:update';

  protected $description = 'update layouts.';

  public function fire()
  {
    $config = $this->getConfig();

    $layouts = array_get($config, 'layouts', []);
    foreach ($layouts as $source => $options)
    {
      $layout   = array_get($options, 'layout', $options);
      $makeBase = !array_get($options, 'no-base', false);
      $engine   = array_get($options, 'engine', 'blade');

      $viewPath = $this->getViewPath($layout, $makeBase);
      if (!$viewPath)
        continue;

      $sourcePath = $this->getSourcePath($source);
      if (!$sourcePath)
        continue;

      $baseView = $this->getBaseView($layout);

      $dwtLayout = $this->getDwtLayout($sourcePath, $viewPath, $layout, $makeBase, $baseView, 'layout');
      $dwtLayout->save($engine);
      $this->info('saved to '.$dwtLayout->saved());
    }
  }

}
