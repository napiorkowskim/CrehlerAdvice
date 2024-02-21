import { CmsBlockAdvicePlugin } from "./plugins";

const PluginManager = window.PluginManager;

PluginManager.register(
    "CmsBlockAdvicePlugin",
    CmsBlockAdvicePlugin,
    "[data-cms-block-advice]",
);