
plugin.tx_glshop {
    view {
        # cat=plugin.tx_glshop/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:glshop/Resources/Private/Templates/
        # cat=plugin.tx_glshop/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:glshop/Resources/Private/Partials/
        # cat=plugin.tx_glshop/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:glshop/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_glshop//a; type=string; label=Default storage PID
        storagePid =
    }
}

module.tx_glshop {
    view {
        # cat=module.tx_glshop/file; type=string; label=Path to template root (BE)
        templateRootPath = EXT:glshop/Resources/Private/Backend/Templates/
        # cat=module.tx_glshop/file; type=string; label=Path to template partials (BE)
        partialRootPath = EXT:glshop/Resources/Private/Backend/Partials/
        # cat=module.tx_glshop/file; type=string; label=Path to template layouts (BE)
        layoutRootPath = EXT:glshop/Resources/Private/Backend/Layouts/
    }
    persistence {
        # cat=module.tx_glshop//a; type=string; label=Default storage PID
        storagePid =
    }
}

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

plugin.tx_glshop {
    settings {
        # cat=plugin.tx_glshop//a; type=integer; label=Shop Data Page (Storage) (FE)
        shopDataPid =
        # cat=plugin.tx_glshop//a; type=integer; label=Shop User Page (Storage) (FE)
        shopUserPid =
        # cat=plugin.tx_glshop//a; type=integer; label=Page whith Homepage (FE)
        homePage =
        # cat=plugin.tx_glshop//a; type=integer; label=Page where Shop is located (FE)
        shopPage =
        # cat=plugin.tx_glshop//a; type=integer; label=Page where Kontakt is located (FE)
        kontaktPage =
        # cat=plugin.tx_glshop//a; type=integer; label=Page where Impressum is included (FE)
        impressumPage =
        # cat=plugin.tx_glshop//a; type=integer; label=Page where AGB is included (FE)
        agbPage =
        # cat=plugin.tx_glshop//a; type=integer; label=Page where Datenschutz is included (FE)
        datenschutzPage =
    }
}