var path = require('path');

module.exports = {
    "extends": "stylelint-config-standard",
    "plugins": [
        __dirname + "/stylelint/selector-path-match-pattern",

        "stylelint-no-unsupported-browser-features",
        "stylelint-no-browser-hacks/lib",
        "stylelint-number-z-index-constraint",

        // под вопросом - непонятно, дает ли он больше, чем обычные правила.
        // т. е. необходимо выяснить, существуют ли случаи, когда csstree
        // срабатывает, а прочие правила - нет.
        // Статус на текущий момент - на всякий случай.
        "stylelint-csstree-validator",
        // не работает для локальных картинок
        // "stylelint-images",
    ],
    "rules": {
        // can be autofixed

        "indentation": null,
        "declaration-block-semicolon-newline-after": null,
        "no-eol-whitespace": null,
        "length-zero-no-unit": null,
        "selector-pseudo-element-colon-notation": null,
        "comment-whitespace-inside": null,
        "rule-empty-line-before": null,
        "declaration-colon-space-after": null,
        "no-extra-semicolons": null,
        "block-opening-brace-space-before": null,
        "comment-empty-line-before": null,
        "max-empty-lines": null,
        "selector-list-comma-newline-after": null,
        "block-closing-brace-empty-line-before": null,
        "no-missing-end-of-source-newline": null,

        /*
         html-template
          */
        // поддержка браузеров
        "plugin/no-unsupported-browser-features": true,
        "plugin/no-browser-hacks": true,

        // без vendor prefix
        "at-rule-no-vendor-prefix": true,
        "media-feature-name-no-vendor-prefix": true,
        "property-no-vendor-prefix": true,
        "selector-no-vendor-prefix": true,
        "value-no-vendor-prefix": true,

        // сложность
        "selector-max-compound-selectors": 5,

        // прочее
        "selector-max-id": 0,
        "comment-word-blacklist": ["/todo/i", "/fix/i"],
        "declaration-property-value-blacklist": {
            "display": "/^table/"
        },
        "declaration-no-important": true,
        "media-feature-name-whitelist": [
            // mobile first: разрешен только min-width
            "min-width"
        ],
        "selector-max-universal": 0,
        // есть в recommended, но с исключениями, а здесь - без исключений
        "declaration-block-no-duplicate-properties": true,
        // почему-то нет в recommended
        "no-duplicate-selectors": true,
        // 1 - для line-height: 1.5
        "number-max-precision": 1,
        // у нас чистый css, а не scss
        "max-nesting-depth": 0,
        "plugin/number-z-index-constraint": {
            "min": 1,
            "max": 3
        },

        // структура css
        "plugin/selector-path-match-pattern": "^ *(\\.l__[a-z]+|body)( |$)",


        // под вопросом
        // интересная штука, но ругается, например, когда li:first-child
        // описан ниже самого li, что не очень удобно.
        // "no-descending-specificity": true,

        // не работает для локальных картинок
        // "images/broken": true,
        // "images/prefer-data-uri": 256000,

        // "declaration-property-unit-whitelist": [{
        //     "width": ['px', '%'],
        //     "height": ['px', '%'],
        //     "left": ['px', '%'],
        //     "right": ['px', '%'],
        //     "top": ['px', '%'],
        //     "bottom": ['px', '%'],
        //     "/^/": ['px']
        // }, {"severity": "warning"}]
        "unit-whitelist": [ ['px', '%'], {"severity": "warning"}],
        "csstree/validator": true
    }
};