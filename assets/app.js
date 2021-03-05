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

    const statusMessages = {
        won: 'You won!',
        lost: 'You lost...',
        draw: "It's as draw.",
    };

    const overlay = $('#loading-cover');
    const loadingImage = $('#loading-image');
    const messageBox = $('#board-message');
    const startGameButton = $('#start-new-game');
    const aiStrategySelector = $('#ttt-strategy-dropdown');

    const showOverlay = function (showLoader, message, showButton) {
        overlay.show();
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

    const onError = function (jqXHR) {
        showOverlay(false, 'Error occurred. Check console.', true);
        console.error('API error occurred.', jqXHR);
    };

    const getJson = function (path, onSuccess) {
        $.ajax({
            method: 'GET',
            url: path,
            dataType: 'json',
            success: onSuccess,
            error: onError,
        });
    }

    const sendJson = function (path, dataObject, onSuccess) {
        $.ajax({
            method: 'POST',
            url: path,
            dataType: 'json',
            data: JSON.stringify(dataObject),
            success: onSuccess,
            error: onError,
        });
    }

    const markCell = function (jElement, mark) {
        mark = mark !== '-' ? mark : ''
        jElement.text(mark);

        if (mark !== '') {
            jElement.removeAttr('data-ttt-cell')
        } else {
            jElement.attr('data-ttt-cell', '')
        }
    }

    const markByCoords = function (row, column, mark) {
        markCell($('#ttt-cell-' + row  + '-' + column), mark)
    }

    const redrawBoard = function (board) {
        board.forEach(
            (row, rowKey) => row.forEach(
                (mark, columnKey) => markByCoords(rowKey, columnKey, mark)
            )
        )
    }

    const consumeGameAndDrawBoard = function (activeGame) {
        game = activeGame;
        redrawBoard(game.board)
        hideOverlay();
    }

    const loadNewGame = function () {
        sendJson(
            '/game',
            {
                strategy: aiStrategySelector.val(),
                playerMark: game.playerMark,
            },
            consumeGameAndDrawBoard
        )
    }

    startGameButton.on('click', loadNewGame)

    $('#ttt-board').on('click', '[data-ttt-cell]', function () {
        showOverlay(true, null, false);
        let cell = $(this);
        markCell(cell, game.playerMark);
        sendJson(
            '/move',
            {
                game: game.id,
                row: cell.data('row'),
                column: cell.data('column'),
                mark: game.playerMark,
            },
            function (gameWithMove) {
                let move = gameWithMove.opponentMove;
                if (move) {
                    markByCoords(move.row, move.column, move.mark)
                }

                let status = gameWithMove.status;
                if (statusMessages.hasOwnProperty(status)) {
                    showOverlay(false, statusMessages[status], true);
                } else {
                    hideOverlay();
                }
            }
        )
    });

    showOverlay(true, null, false);
    getJson(
        '/game/active',
        function (activeGame) {
            if (activeGame) {
                consumeGameAndDrawBoard(activeGame)
            } else {
                loadNewGame()
            }
        }
    )
});
