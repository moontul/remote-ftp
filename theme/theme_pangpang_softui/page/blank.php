<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}
if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="76x76" href="https://demos.creative-tim.com/argon-design-system-pro/assets/img/apple-icon.png">
    <link rel="icon" href="https://demos.creative-tim.com/argon-design-system-pro/assets/img/apple-icon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Creative Tim">
    <title>
      Typed | Soft UI Design System Bootstrap @ Creative Tim
    </title>
    <link rel="canonical" href="https://www.creative-tim.com/learning-lab/bootstrap/typed/soft-ui-design-system" />
    <meta name="keywords" content="">
    <meta name="description" content="Typed.js is a library that types. Enter in any string, and watch it type at the speed you've set, backspace what it's typed, and begin a new sentence for however many strings you've set.">
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@creativetim">
    <meta name="twitter:title" content="Typed | Soft UI Design System Bootstrap @ Creative Tim">
    <meta name="twitter:description" content="Typed.js is a library that types. Enter in any string, and watch it type at the speed you've set, backspace what it's typed, and begin a new sentence for however many strings you've set.">
    <meta name="twitter:creator" content="@creativetim">
    <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/414/thumb/opt_sds_thumbnail.png">
    <meta property="fb:app_id" content="655968634437471">
    <meta property="og:title" content="Typed | Soft UI Design System Bootstrap @ Creative Tim" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://demos.creative-tim.com/soft-ui-design-system-pro/presentation.html" />
    <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/414/thumb/opt_sds_thumbnail.png" />
    <meta property="og:description" content="Typed.js is a library that types. Enter in any string, and watch it type at the speed you've set, backspace what it's typed, and begin a new sentence for however many strings you've set." />
    <meta property="og:site_name" content="Creative Tim" />
    <link rel="stylesheet" href="https://demos.creative-tim.com/argon-design-system-pro/assets/css/nucleo-icons.css" type="text/css">
    <link href="" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/css/soft-design-system-pro.min.css?v=1.0.0" type="text/css">
    <link href="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/css/soft-design-system-pro.min.css?v=1.0.0" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://demos.creative-tim.com/argon-design-system-pro/assets/css/nucleo-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Anti-flicker snippet (recommended)  -->
    <style>
      .async-hide {
        opacity: 0 !important
      }
    </style>
    <script>
      (function(a, s, y, n, c, h, i, d, e) {
        s.className += ' ' + y;
        h.start = 1 * new Date;
        h.end = i = function() {
          s.className = s.className.replace(RegExp(' ?' + y), '')
        };
        (a[n] = a[n] || []).hide = h;
        setTimeout(function() {
          i();
          h.end = null
        }, c);
        h.timeout = c;
      })(window, document.documentElement, 'async-hide', 'dataLayer', 4000, {
        'GTM-K9BGS8K': true
      });
    </script>
    <!-- Analytics-Optimize Snippet -->
    <script>
      (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
          (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
          m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
      })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
      ga('create', 'UA-46172202-22', 'auto', {
        allowLinker: true
      });
      ga('set', 'anonymizeIp', true);
      ga('require', 'GTM-K9BGS8K');
      ga('require', 'displayfeatures');
      ga('require', 'linker');
      ga('linker:autoLink', ["2checkout.com", "avangate.com"]);
    </script>
    <!-- end Analytics-Optimize Snippet -->
    <!-- Google Tag Manager -->
    <script>
      (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
          'gtm.start': new Date().getTime(),
          event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s),
          dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', 'GTM-NKDMSK6');
    </script>
    <!-- End Google Tag Manager -->
    <!-- This is for docs typography and layout -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="../../assets/docs-soft.css" rel="stylesheet" />
  </head>

  <body class="docs ">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header class="ct-docs-navbar">
      <a class="ct-docs-navbar-brand" href="javascript:void(0)" aria-label="Bootstrap">
        <a href="https://www.creative-tim.com/" class="ct-docs-navbar-text" target="_blank">
          Creative Tim
        </a>
        <div class="ct-docs-navbar-border"></div>
        <a href="../overview/soft-ui-design-system" class="ct-docs-navbar-text">
          Docs
        </a>
      </a>
      <ul class="ct-docs-navbar-nav-left">
        <li class="ct-docs-nav-item-dropdown">
          <a href="javascript:;" class="ct-docs-navbar-nav-link" role="button">
            <span class="ct-docs-navbar-nav-link-inner--text">Live Preview</span>
          </a>
          <div class="ct-docs-navbar-dropdown-menu" aria-labelledby="DropdownPreview">
            <a class="ct-docs-navbar-dropdown-item" href="https://demos.creative-tim.com/soft-ui-design-system/index.html" target="_blank">
              Soft UI Design System
            </a>
            <a class="ct-docs-navbar-dropdown-item" href="https://demos.creative-tim.com/soft-ui-design-system-pro/presentation.html" target="_blank">
              Soft UI Design System Pro
            </a>
          </div>
        </li>
        <li class="ct-docs-nav-item-dropdown">
          <a href="javascript:;" class="ct-docs-navbar-nav-link" role="button">
            <span class="ct-docs-navbar-nav-link-inner--text">Support</span>
          </a>
          <div class="ct-docs-navbar-dropdown-menu" aria-labelledby="DropdownSupport">
            <a class="ct-docs-navbar-dropdown-item" href="https://github.com/creativetimofficial/soft-ui-design-system/issues" target="_blank">
              Soft UI Design System
            </a>
            <a class="ct-docs-navbar-dropdown-item" href="https://github.com/creativetimofficial/ct-soft-ui-design-system-pro/issues" target="_blank">
              Soft UI Design System Pro
            </a>
          </div>
        </li>
      </ul>
      <ul class="ct-docs-navbar-nav-right">
        <li class="ct-docs-navbar-nav-item">
          <a class="ct-docs-navbar-nav-link" href="https://www.creative-tim.com/product/soft-ui-design-system" target="_blank">Download Free</a>
        </li>
      </ul>
      <a href="https://creative-tim.com/product/soft-ui-design-system-pro" target="_blank" class="ct-docs-btn-upgrade">
        <span class="ct-docs-btn-inner--icon">
          <i class="fas fa-download mr-2"></i>
        </span>
        <span class="ct-docs-navbar-nav-link-inner--text">Upgrade to PRO</span>
      </a>
      <button class="ct-docs-navbar-toggler" type="button">
        <span class="ct-docs-navbar-toggler-icon"></span>
      </button>
    </header>
    <div class="ct-docs-main-container">
      <div class="ct-docs-main-content-row">
        <div class="ct-docs-sidebar-col">
          <nav class="ct-docs-sidebar-collapse-links">
            <div class="ct-docs-sidebar-product">
              <div class="ct-docs-sidebar-product-image">
                <img src="../../assets/images/bootstrap-5.svg">
              </div>
              <p class="ct-docs-sidebar-product-text">Soft UI Design System</p>
            </div>
            <hr class="horizontal dark mt-0">
            <div class="ct-docs-toc-item-active">
              <a class="ct-docs-toc-link" href="javascript:void(0)">
                <div class="d-inline-block">
                  <div class="icon icon-xs border-radius-md bg-gradient-primary text-center mr-2 d-flex align-items-center justify-content-center me-1">
                    <i class="ni ni-active-40 text-white"></i>
                  </div>
                </div>
                Getting started
              </a>
              <ul class="ct-docs-nav-sidenav ms-4 ps-1">
                <li class="">
                  <a href="../../bootstrap/overview/soft-ui-design-system">
                    Overview
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/license/soft-ui-design-system">
                    License
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/quick-start/soft-ui-design-system">
                    Quick Start
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/build-tools/soft-ui-design-system">
                    Build Tools
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/what-is-bootstrap/soft-ui-design-system">
                    What is Bootstrap
                  </a>
                </li>
              </ul>
            </div>
            <div class="ct-docs-toc-item-active">
              <a class="ct-docs-toc-link" href="javascript:void(0)">
                <div class="d-inline-block">
                  <div class="icon icon-xs border-radius-md bg-gradient-primary text-center mr-2 d-flex align-items-center justify-content-center me-1">
                    <i class="ni ni-folder-17 text-white"></i>
                  </div>
                </div>
                Foundation
              </a>
              <ul class="ct-docs-nav-sidenav ms-4 ps-1">
                <li class="">
                  <a href="../../bootstrap/colors/soft-ui-design-system">
                    Colors
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/grid/soft-ui-design-system">
                    Grid
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/typography/soft-ui-design-system">
                    Typography
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/icons/soft-ui-design-system">
                    Icons
                  </a>
                </li>
              </ul>
            </div>
            <div class="ct-docs-toc-item-active">
              <a class="ct-docs-toc-link" href="javascript:void(0)">
                <div class="d-inline-block">
                  <div class="icon icon-xs border-radius-md bg-gradient-primary text-center mr-2 d-flex align-items-center justify-content-center me-1">
                    <i class="ni ni-bulb-61 text-white"></i>
                  </div>
                </div>
                Utilities
              </a>
              <ul class="ct-docs-nav-sidenav ms-4 ps-1">
                <li class="">
                  <a href="../../bootstrap/utilities/soft-ui-design-system">
                    Bootstrap
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/utilities-product/soft-ui-design-system">
                    Soft UI
                  </a>
                </li>
              </ul>
            </div>
            <div class="ct-docs-toc-item-active">
              <a class="ct-docs-toc-link" href="javascript:void(0)">
                <div class="d-inline-block">
                  <div class="icon icon-xs border-radius-md bg-gradient-primary text-center mr-2 d-flex align-items-center justify-content-center me-1">
                    <i class="ni ni-app text-white"></i>
                  </div>
                </div>
                Components
              </a>
              <ul class="ct-docs-nav-sidenav ms-4 ps-1">
                <li class="">
                  <a href="../../bootstrap/alerts/soft-ui-design-system">
                    Alerts
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/badge/soft-ui-design-system">
                    Badge
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/buttons/soft-ui-design-system">
                    Buttons
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/social-buttons/soft-ui-design-system">
                    Social Buttons
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/cards/soft-ui-design-system">
                    Cards
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/carousel/soft-ui-design-system">
                    Carousel
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/collapse/soft-ui-design-system">
                    Collapse
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/dropdowns/soft-ui-design-system">
                    Dropdowns
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/forms/soft-ui-design-system">
                    Forms
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/input-group/soft-ui-design-system">
                    Input Group
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/list-group/soft-ui-design-system">
                    List Group
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/modal/soft-ui-design-system">
                    Modal
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/navs/soft-ui-design-system">
                    Navs
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/navbar/soft-ui-design-system">
                    Navbar
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/pagination/soft-ui-design-system">
                    Pagination
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/popovers/soft-ui-design-system">
                    Popovers
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/progress/soft-ui-design-system">
                    Progress
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/tables/soft-ui-design-system">
                    Tables
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/tooltips/soft-ui-design-system">
                    Tooltips
                  </a>
                </li>
              </ul>
            </div>
            <div class="ct-docs-toc-item-active">
              <a class="ct-docs-toc-link" href="javascript:void(0)">
                <div class="d-inline-block">
                  <div class="icon icon-xs border-radius-md bg-gradient-primary text-center mr-2 d-flex align-items-center justify-content-center me-1">
                    <i class="ni ni-settings text-white"></i>
                  </div>
                </div>
                Plugins
              </a>
              <ul class="ct-docs-nav-sidenav ms-4 ps-1">
                <li class="">
                  <a href="../../bootstrap/audio-player/soft-ui-design-system">
                    Audio Player
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/datepicker/soft-ui-design-system">
                    Datepicker
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/sliders/soft-ui-design-system">
                    Sliders
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
                <li class="">
                  <a href="../../bootstrap/choices/soft-ui-design-system">
                    Choices
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
                <li class=" ct-docs-nav-sidenav-active ">
                  <a href="../../bootstrap/typed/soft-ui-design-system">
                    Typed
                    <span class="ct-docs-sidenav-pro-badge">Pro</span>
                  </a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
        <div class="ct-docs-toc-col">
          <ul class="section-nav">
            <li class="toc-entry toc-h2"><a href="#examples">Examples</a></li>
            <li class="toc-entry toc-h1"><a href="#work-with-an-amazing-">Work with an amazing </a></li>
            <li class="toc-entry toc-h1"><a href="#team">team</a></li>
            <li class="toc-entry toc-h1"><a href="#design">design</a></li>
            <li class="toc-entry toc-h1"><a href="#tool">tool</a></li>
          </ul>
        </div>
        <main class="ct-docs-content-col" role="main">
          <div class="ct-docs-page-title">
            <h1 class="ct-docs-page-h1-title" id="content">
              Bootstrap Typed
            </h1>
            <span class="ct-docs-page-title-pro-line"> - </span>
            <div class="ct-docs-page-title-pro-bage">Pro Component</div>
            <div class="avatar-group mt-3">
            </div>
          </div>
          <p class="ct-docs-page-title-lead">Typed.js is a library that types. Enter in any string, and watch it type at the speed you’ve set, backspace what it’s typed, and begin a new sentence for however many strings you’ve set.</p>
          <hr class="ct-docs-hr">
          <h2 id="examples">Examples</h2>
          <h1 class="text-dark">Work with an amazing <span class="text-dark" id="typed"></span></h1>
          <div id="typed-strings">
            <h1>team</h1>
            <h1>design</h1>
            <h1>tool</h1>
          </div>
          <div class="position-relative">
            <figure class="highlight"><pre><code class="language-html" data-lang="html"><span class="nt">&lt;h1</span> <span class="na">class=</span><span class="s">"text-dark"</span><span class="nt">&gt;</span>Work with an amazing <span class="nt">&lt;span</span> <span class="na">class=</span><span class="s">"text-dark"</span> <span class="na">id=</span><span class="s">"typed"</span><span class="nt">&gt;&lt;/span&gt;&lt;/h1&gt;</span>
  <span class="nt">&lt;div</span> <span class="na">id=</span><span class="s">"typed-strings"</span><span class="nt">&gt;</span>
     <span class="nt">&lt;h1&gt;</span>team<span class="nt">&lt;/h1&gt;</span>
     <span class="nt">&lt;h1&gt;</span>design<span class="nt">&lt;/h1&gt;</span>
     <span class="nt">&lt;h1&gt;</span>tool<span class="nt">&lt;/h1&gt;</span>
  <span class="nt">&lt;/div&gt;</span>

  <span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span><span class="nt">&gt;</span>
    <span class="k">if</span> <span class="p">(</span><span class="nb">document</span><span class="p">.</span><span class="nx">getElementById</span><span class="p">(</span><span class="dl">'</span><span class="s1">typed</span><span class="dl">'</span><span class="p">))</span> <span class="p">{</span>
      <span class="kd">var</span> <span class="nx">typed</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Typed</span><span class="p">(</span><span class="dl">"</span><span class="s2">#typed</span><span class="dl">"</span><span class="p">,</span> <span class="p">{</span>
        <span class="na">stringsElement</span><span class="p">:</span> <span class="dl">'</span><span class="s1">#typed-strings</span><span class="dl">'</span><span class="p">,</span>
        <span class="na">typeSpeed</span><span class="p">:</span> <span class="mi">90</span><span class="p">,</span>
        <span class="na">backSpeed</span><span class="p">:</span> <span class="mi">90</span><span class="p">,</span>
        <span class="na">backDelay</span><span class="p">:</span> <span class="mi">200</span><span class="p">,</span>
        <span class="na">startDelay</span><span class="p">:</span> <span class="mi">500</span><span class="p">,</span>
        <span class="na">loop</span><span class="p">:</span> <span class="kc">true</span>
      <span class="p">});</span>
    <span class="p">}</span>
  <span class="nt">&lt;/script&gt;</span></code></pre>
            </figure>
          </div>
        </main>
      </div>
      <div class="ct-docs-main-footer-row">
        <div class="ct-docs-main-footer-blank-col">
        </div>
        <div class="ct-docs-main-footer-col">
          <footer class="ct-docs-footer">
            <div class="ct-docs-footer-inner-row">
              <div class="ct-docs-footer-col">
                <div class="ct-docs-footer-copyright">
                  © <script>
                    document.write(new Date().getFullYear())
                  </script> <a href="https://creative-tim.com" class="ct-docs-footer-copyright-author" target="_blank">Creative Tim</a>
                </div>
              </div>
              <div class="ct-docs-footer-col">
                <ul class="ct-docs-footer-nav-footer">
                  <li>
                    <a href="https://creative-tim.com" class="ct-docs-footer-nav-link" target="_blank">Creative Tim</a>
                  </li>
                  <li>
                    <a href="https://www.creative-tim.com/contact-us" class="ct-docs-footer-nav-link" target="_blank">Contact Us</a>
                  </li>
                  <li>
                    <a href="https://creative-tim.com/blog" class="ct-docs-footer-nav-link" target="_blank">Blog</a>
                  </li>
                </ul>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
    <script src="https://demos.creative-tim.com/argon-dashboard-pro-bs4/assets/vendor/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="" type="text/javascript"></script>
    <script src="" type="text/javascript"></script>
    <script src="" type="text/javascript"></script>
    <script src="" type="text/javascript"></script>
    <script src="https://demos.creative-tim.com/argon-dashboard-pro-bs4/assets/vendor/prismjs/prism.js" type="text/javascript"></script>
    <script src="https://demos.creative-tim.com/argon-design-system-pro/assets/demo/docs.min.js" type="text/javascript"></script>
    <script src="https://demos.creative-tim.com/argon-design-system-pro/assets/demo/vendor/holder.min.js" type="text/javascript"></script>
    <script src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/js/plugins/moment.min.js" type="text/javascript"></script>
    <script src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/js/plugins/typedjs.js" type="text/javascript"></script>
    <script src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/js/soft-design-system-pro.min.js?v=1.0.0" type="text/javascript"></script>
    <script>
      Holder.addTheme('gray', {
        bg: '#777',
        fg: 'rgba(255,255,255,.75)',
        font: 'Helvetica',
        fontweight: 'normal'
      })
    </script>
    <script>
      // Facebook Pixel Code Don't Delete
      ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
          n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
      }(window,
        document, 'script', '//connect.facebook.net/en_US/fbevents.js');

      try {
        fbq('init', '111649226022273');
        fbq('track', "PageView");

      } catch (err) {
        console.log('Facebook Track Error:', err);
      }
    </script>
    <script src="../../assets/docs.js"></script>
    <script type="text/javascript">
      if (document.getElementById('typed')) {
        var typed = new Typed("#typed", {
          stringsElement: '#typed-strings',
          typeSpeed: 90,
          backSpeed: 90,
          backDelay: 200,
          startDelay: 500,
          loop: true
        });
      }
    </script>
  </body>

</html>
