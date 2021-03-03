// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import $ from 'jquery'

$(function() {
    let game = {
        id: null,
        strategy: null,
        playerMark: 'X',
        status: null,
    };

    const overlay = $('#loading-cover');
    const loadingImage = $('#loading-image');
    const messageBox = $('#board-message');
    const startGameButton = $('#start-new-game');
    const aiStrategySelector = $('#ttt-strategy-dropdown');

    const showOverlay = function (showLoader, message, showButton) {
        loadingImage.toggle(showLoader);
        if (message) {
            messageBox.text(message).show();
        } else {
            messageBox.hide();
        }
        startGameButton.toggle(showButton);
    }

    const hideOverlay = function () {
        overlay.hide();
    }

    const sendJson = function (path, dataObject, onSuccess) {
        $.ajax({
            method: 'POST',
            url: path,
            dataType: 'json',
            data: JSON.stringify(dataObject),
            success: onSuccess,
            error: function (jqXHR) {
                showOverlay(false, 'Error occurred. Check console.', true);
                console.error('API error occurred.', jqXHR);
            }
        });
    }

    const markCell = function (jElement, mark) {
        jElement
            .removeAttr('data-ttt-cell')
            .text(mark);
    }

    startGameButton.on('click', function () {
        sendJson(
            '/game',
            {
                strategy: aiStrategySelector.val(),
                playerMark: game.playerMark,
            },
            function (newGame) {
                game = newGame;
                hideOverlay();
            }
        )
    })

    $('#ttt-board').on('click', '[data-ttt-cell]', function () {
        showOverlay(true, null, false);
        markCell($(this), game.playerMark);
        setTimeout(hideOverlay, 200);
    });

    // Show new game button (loading unfinished game is yet not supported)
    showOverlay(false, 'No active game found.', true);
});
