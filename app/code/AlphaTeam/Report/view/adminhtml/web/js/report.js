define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {
        const $form = $(element);
        const $submitButton = $form.find('button[type="submit"]');

        $form.on('submit', function () {
            $submitButton.attr('disabled', true);
        });
    };
});
