// Import external dependencies
import 'jquery';

// Import everything from autoload
import "./autoload/**/*"

// Import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';

// Base Font Awesome 5 package
// How to use it: https://discourse.roots.io/t/how-to-use-font-awesome-5-in-your-sage-theme/11737
import fontawesome from "@fortawesome/fontawesome";
// Facebook and Twitter icons
import faFacebook from "@fortawesome/fontawesome-free-brands/faFacebook";
import faTwitter from "@fortawesome/fontawesome-free-brands/faTwitter";

// Add the imported icons to the library
fontawesome.library.add(faFacebook, faTwitter);

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
