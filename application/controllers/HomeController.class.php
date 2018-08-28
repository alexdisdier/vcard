<?php

class HomeController
{
    // Get the informations from the following tables to display front-end
    public function httpGetMethod()
    {
        $aboutModel   = new AboutModel();
        $abouts       = $aboutModel->listAll();

        $siteModel    = new SiteModel();
        $sites        = $siteModel->listAll();

        $socialModel  = new SocialModel();
        $socials      = $socialModel->listAll();

        $quotesModel  = new QuotesModel();
        $quotes       = $quotesModel->listAll();

        $coverModel   = new CoverModel();
        $cover        = $coverModel->listAll();

        $profileModel = new ProfileModel();
        $profile      = $profileModel->listAll();

        $metaModel    = new MetaModel();
        $metas        = $metaModel->listAll();

        return
        [
            'flashBag'    => new FlashBag(),
            'abouts'      => $abouts,
            'sites'       => $sites,
            'socials'     => $socials,
            'quotes'      => $quotes,
            'cover'       => $cover,
            'profile'     => $profile,
            'metas'       => $metas,
        ];
    }

}
