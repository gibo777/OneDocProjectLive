<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" /> -->

        <title><?php echo e(config('app.name', 'One Document Corporation')); ?></title>

        <!-- Fonts -->
        

        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">

        <?php echo \Livewire\Livewire::styles(); ?>


<!-- Scripts -->

<script src="<?php echo e(mix('js/app.js')); ?>" defer></script>
<script src="<?php echo e(asset('/sweetalert/js/sweetalert.js')); ?>"></script>
<link href="<?php echo e(asset('/sweetalert/css/sweetalert.css')); ?>" rel='stylesheet' type='text/css'>


<!-- font awesome  -->
<link rel="stylesheet" href="<?php echo e(asset('/fontawesome-6.2.0/css/all.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('/jquery-ui-1.13.1.custom/jquery-ui.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/jquery-ui-1.13.1.custom/jquery-ui.min.css')); ?>">

<script type="text/javascript" src="<?php echo e(asset('/js/jquery.min-3.6.0.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('/js/jquery-3.6.0.min.js')); ?>"></script>



<link rel="stylesheet" href="<?php echo e(asset('/bootstrap-5.0.2-dist/css/bootstrap.css')); ?>">
<script type="text/javascript" src="<?php echo e(asset('/bootstrap-5.0.2-dist/js/bootstrap.js')); ?>"></script>



<link rel="stylesheet" href="<?php echo e(asset('/multiple-select/css/style.css')); ?>">
<script src="<?php echo e(asset('/multiple-select/js/popper.js')); ?>"></script>
<script src="<?php echo e(asset('/multiple-select/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('/multiple-select/js/bootstrap-multiselect.js')); ?>"></script>



<script type="text/javascript" src="<?php echo e(asset('/jquery-ui-1.13.1.custom/jquery-ui.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('/jquery-ui-1.13.1.custom/jquery-ui.min.js')); ?>"></script>
<!-- TABLE WITH PAGINATION end -->





<script type="text/javascript" src="<?php echo e(asset('ckeditor/ckeditor.js')); ?>"></script>
<script src="<?php echo e(asset('/js/pusher.min.js')); ?>"></script>



<link rel="stylesheet" type="text/css" href="<?php echo e(asset('DataTables/datatables.min.css')); ?>"/>
<script type="text/javascript" src="<?php echo e(asset('DataTables/datatables.min.js')); ?>"></script>


<link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
<script type="text/javascript" src="<?php echo e(asset('/js/main.js')); ?>"></script>


<script src="<?php echo e(asset('js/webcam.js')); ?>"></script>

<link rel="shortcut icon" href="<?php echo e(asset('img/all/onedoc-favicon.png')); ?>">

    </head>
    <body class="font-sans antialiased">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.banner','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="min-h-screen bg-gray-100" id="module_content">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('navigation-menu')->html();
} elseif ($_instance->childHasBeenRendered('0Fi1klG')) {
    $componentId = $_instance->getRenderedChildComponentId('0Fi1klG');
    $componentTag = $_instance->getRenderedChildComponentTagName('0Fi1klG');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('0Fi1klG');
} else {
    $response = \Livewire\Livewire::mount('navigation-menu');
    $html = $response->html();
    $_instance->logRenderedChild('0Fi1klG', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header id="module_header" class="bg-white shadow banner-blue font-white-bold hover">
                    <!-- <div class="max-w-7xl mx-auto py-2 px-2 sm:px-6 lg:px-8"> -->
                    <div class="mx-auto px-4 sm:px-6 lg:px-8 text-xl py-1 fw-bold">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <div class="overflow-auto max-h-[500px]">
                    <?php echo e($slot); ?>

                </div>
            </main>

        </div>

        <?php echo $__env->yieldPushContent('modals'); ?>

        <?php echo \Livewire\Livewire::scripts(); ?>

    </body>

    
    <script>
        $(document).ready(function() {
            $("#module_header").click(function() {
                $("#nav_header").toggle();
            });
        });
        (function($) {

            function appendContent($el, content) {
                if (!content) return;

                // Simple test for a jQuery element
                $el.append(content.jquery ? content.clone() : content);
            }

            function appendBody($body, $element, opt) {
                // Clone for safety and convenience
                // Calls clone(withDataAndEvents = true) to copy form values.
                var $content = $element.clone(opt.formValues);

                if (opt.formValues) {
                    // Copy original select and textarea values to their cloned counterpart
                    // Makes up for inability to clone select and textarea values with clone(true)
                    copyValues($element, $content, 'select, textarea');
                }

                if (opt.removeScripts) {
                    $content.find('script').remove();
                }

                if (opt.printContainer) {
                    // grab $.selector as container
                    $content.appendTo($body);
                } else {
                    // otherwise just print interior elements of container
                    $content.each(function() {
                        $(this).children().appendTo($body)
                    });
                }
            }

            // Copies values from origin to clone for passed in elementSelector
            function copyValues(origin, clone, elementSelector) {
                var $originalElements = origin.find(elementSelector);

                clone.find(elementSelector).each(function(index, item) {
                    $(item).val($originalElements.eq(index).val());
                });
            }

            var opt;
            $.fn.printThis = function(options) {
                opt = $.extend({}, $.fn.printThis.defaults, options);
                var $element = this instanceof jQuery ? this : $(this);

                var strFrameName = "printThis-" + (new Date()).getTime();

                if (window.location.hostname !== document.domain && navigator.userAgent.match(/msie/i)) {
                    // Ugly IE hacks due to IE not inheriting document.domain from parent
                    // checks if document.domain is set by comparing the host name against document.domain
                    var iframeSrc = "javascript:document.write(\"<head><script>document.domain=\\\"" + document.domain + "\\\";</s" + "cript></head><body></body>\")";
                    var printI = document.createElement('iframe');
                    printI.name = "printIframe";
                    printI.id = strFrameName;
                    printI.className = "MSIE";
                    document.body.appendChild(printI);
                    printI.src = iframeSrc;

                } else {
                    // other browsers inherit document.domain, and IE works if document.domain is not explicitly set
                    var $frame = $("<iframe id='" + strFrameName + "' name='printIframe' />");
                    $frame.appendTo("body");
                }

                var $iframe = $("#" + strFrameName);

                // show frame if in debug mode
                if (!opt.debug) $iframe.css({
                    position: "absolute",
                    width: "0px",
                    height: "0px",
                    left: "-600px",
                    top: "-600px"
                });

                // before print callback
                if (typeof opt.beforePrint === "function") {
                    opt.beforePrint();
                }

                // $iframe.ready() and $iframe.load were inconsistent between browsers
                setTimeout(function() {

                    // Add doctype to fix the style difference between printing and render
                    function setDocType($iframe, doctype){
                        var win, doc;
                        win = $iframe.get(0);
                        win = win.contentWindow || win.contentDocument || win;
                        doc = win.document || win.contentDocument || win;
                        doc.open();
                        doc.write(doctype);
                        doc.close();
                    }

                    if (opt.doctypeString){
                        setDocType($iframe, opt.doctypeString);
                    }

                    var $doc = $iframe.contents(),
                        $head = $doc.find("head"),
                        $body = $doc.find("body"),
                        $base = $('base'),
                        baseURL;

                    // add base tag to ensure elements use the parent domain
                    if (opt.base === true && $base.length > 0) {
                        // take the base tag from the original page
                        baseURL = $base.attr('href');
                    } else if (typeof opt.base === 'string') {
                        // An exact base string is provided
                        baseURL = opt.base;
                    } else {
                        // Use the page URL as the base
                        baseURL = document.location.protocol + '//' + document.location.host;
                    }

                    $head.append('<base href="' + baseURL + '">');

                    // import page stylesheets
                    if (opt.importCSS) $("link[rel=stylesheet]").each(function() {
                        var href = $(this).attr("href");
                        if (href) {
                            var media = $(this).attr("media") || "all";
                            $head.append("<link type='text/css' rel='stylesheet' href='" + href + "' media='" + media + "'>");
                        }
                    });

                    // import style tags
                    if (opt.importStyle) $("style").each(function() {
                        $head.append(this.outerHTML);
                    });

                    // add title of the page
                    if (opt.pageTitle) $head.append("<title>" + opt.pageTitle + "</title>");

                    // import additional stylesheet(s)
                    if (opt.loadCSS) {
                        if ($.isArray(opt.loadCSS)) {
                            jQuery.each(opt.loadCSS, function(index, value) {
                                $head.append("<link type='text/css' rel='stylesheet' href='" + this + "'>");
                            });
                        } else {
                            $head.append("<link type='text/css' rel='stylesheet' href='" + opt.loadCSS + "'>");
                        }
                    }

                    var pageHtml = $('html')[0];

                    // CSS VAR in html tag when dynamic apply e.g.  document.documentElement.style.setProperty("--foo", bar);
                    $doc.find('html').prop('style', pageHtml.style.cssText);

                    // copy 'root' tag classes
                    var tag = opt.copyTagClasses;
                    if (tag) {
                        tag = tag === true ? 'bh' : tag;
                        if (tag.indexOf('b') !== -1) {
                            $body.addClass($('body')[0].className);
                        }
                        if (tag.indexOf('h') !== -1) {
                            $doc.find('html').addClass(pageHtml.className);
                        }
                    }

                    // copy ':root' tag classes
                    tag = opt.copyTagStyles;
                    if (tag) {
                        tag = tag === true ? 'bh' : tag;
                        if (tag.indexOf('b') !== -1) {
                            $body.attr('style', $('body')[0].style.cssText);
                        }
                        if (tag.indexOf('h') !== -1) {
                            $doc.find('html').attr('style', pageHtml.style.cssText);
                        }
                    }

                    // print header
                    appendContent($body, opt.header);

                    if (opt.canvas) {
                        // add canvas data-ids for easy access after cloning.
                        var canvasId = 0;
                        // .addBack('canvas') adds the top-level element if it is a canvas.
                        $element.find('canvas').addBack('canvas').each(function(){
                            $(this).attr('data-printthis', canvasId++);
                        });
                    }

                    appendBody($body, $element, opt);

                    if (opt.canvas) {
                        // Re-draw new canvases by referencing the originals
                        $body.find('canvas').each(function(){
                            var cid = $(this).data('printthis'),
                                $src = $('[data-printthis="' + cid + '"]');

                            this.getContext('2d').drawImage($src[0], 0, 0);

                            // Remove the markup from the original
                            if ($.isFunction($.fn.removeAttr)) {
                                $src.removeAttr('data-printthis');
                            } else {
                                $.each($src, function(i, el) {
                                    el.removeAttribute('data-printthis');
                                });
                            }
                        });
                    }

                    // remove inline styles
                    if (opt.removeInline) {
                        // Ensure there is a selector, even if it's been mistakenly removed
                        var selector = opt.removeInlineSelector || '*';
                        // $.removeAttr available jQuery 1.7+
                        if ($.isFunction($.removeAttr)) {
                            $body.find(selector).removeAttr("style");
                        } else {
                            $body.find(selector).attr("style", "");
                        }
                    }

                    // print "footer"
                    appendContent($body, opt.footer);

                    // attach event handler function to beforePrint event
                    function attachOnBeforePrintEvent($iframe, beforePrintHandler) {
                        var win = $iframe.get(0);
                        win = win.contentWindow || win.contentDocument || win;

                        if (typeof beforePrintHandler === "function") {
                            if ('matchMedia' in win) {
                                win.matchMedia('print').addListener(function(mql) {
                                    if(mql.matches)  beforePrintHandler();
                                });
                            } else {
                                win.onbeforeprint = beforePrintHandler;
                            }
                        }
                    }
                    attachOnBeforePrintEvent($iframe, opt.beforePrintEvent);

                    setTimeout(function() {
                        if ($iframe.hasClass("MSIE")) {
                            // check if the iframe was created with the ugly hack
                            // and perform another ugly hack out of neccessity
                            window.frames["printIframe"].focus();
                            $head.append("<script>  window.print(); </s" + "cript>");
                        } else {
                            // proper method
                            if (document.queryCommandSupported("print")) {
                                $iframe[0].contentWindow.document.execCommand("print", false, null);
                            } else {
                                $iframe[0].contentWindow.focus();
                                $iframe[0].contentWindow.print();
                            }
                        }

                        // remove iframe after print
                        if (!opt.debug) {
                            setTimeout(function() {
                                $iframe.remove();

                            }, 1000);
                        }

                        // after print callback
                        if (typeof opt.afterPrint === "function") {
                            opt.afterPrint();
                        }

                    }, opt.printDelay);

                }, 333);

            };

            // defaults
            $.fn.printThis.defaults = {
                debug: false,                       // show the iframe for debugging
                importCSS: true,                    // import parent page css
                importStyle: true,                  // import style tags
                printContainer: true,               // print outer container/$.selector
                loadCSS: "",                        // path to additional css file - use an array [] for multiple
                pageTitle: "",                      // add title to print page
                removeInline: false,                // remove inline styles from print elements
                removeInlineSelector: "*",          // custom selectors to filter inline styles. removeInline must be true
                printDelay: 1000,                   // variable print delay
                header: null,                       // prefix to html
                footer: null,                       // postfix to html
                base: false,                        // preserve the BASE tag or accept a string for the URL
                formValues: true,                   // preserve input/form values
                canvas: true,                       // copy canvas content
                doctypeString: '<!DOCTYPE html>',   // enter a different doctype for older markup
                removeScripts: false,               // remove script tags from print content
                copyTagClasses: true,               // copy classes from the html & body tag
                copyTagStyles: true,                // copy styles from html & body tag (for CSS Variables)
                beforePrintEvent: null,             // callback function for printEvent in iframe
                beforePrint: null,                  // function called before iframe is filled
                afterPrint: null                    // function called before iframe is removed
            };
        })(jQuery);

            </script>
</html>
<?php /**PATH C:\xampp\htdocs\OneDocProjectLive\resources\views/layouts/app.blade.php ENDPATH**/ ?>