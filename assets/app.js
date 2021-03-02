// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import $ from 'jquery'

$(function() {
    const loader = $('#loading-cover');

    const showLoader = function () {
        loader.show();
    }

    const hideLoader = function () {
        loader.hide();
    }

    $('#ttt-board').on('click', '[data-ttt-cell]', function () {
        showLoader();
        $(this)
            .removeAttr('data-ttt-cell')
            .text('X');
        setTimeout(hideLoader, 200);
    });
});
