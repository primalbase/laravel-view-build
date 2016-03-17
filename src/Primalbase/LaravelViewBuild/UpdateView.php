<?php namespace Primalbase\LaravelViewBuild;

class UpdateView extends CommandBase {

  protected $name = 'view:update';

  protected $description = 'update views.';

  public function fire()
  {
    $config = $this->getConfig();

    $views = array_get($config, 'views', []);
    foreach ($views as $source => $options)
    {
      $view     = array_get($options, 'view', $options);
      $layout   = array_get($options, 'layout', 'layout.main');
      $makeBase = !array_get($options, 'no-base', false);
      $engine   = array_get($options, 'engine', 'blade');

      $viewPath = $this->getViewPath($view);
      if (!$viewPath)
        continue;

      $sourcePath = $this->getSourcePath($source, false);
      if (!$sourcePath)
        continue;

      $baseView = $this->getBaseView($view);

      $dwtLayout = $this->getDwtLayout($source, $viewPath, $layout, $makeBase, $baseView, 'view');
      $dwtLayout->save($engine);
      $this->info('saved to '.$dwtLayout->saved());
    }
  }

}
