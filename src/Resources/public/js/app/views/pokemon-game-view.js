import $ from 'jquery';
import _ from 'underscore';
import BaseView from 'oroui/js/app/views/base/view';
import routing from 'routing';
import mediator from 'oroui/js/mediator';

const PokemonGameView = BaseView.extend({
    elem: {
        gameArea: '#pokemon-game-area',
        scoreDisplay: '#pokemon-score',
        startGameButton: '#start-game',
        stopGameButton: '#stop-game'
    },

    score: 0,
    imageUrls: [],
    displayedCount: 0,
    unclickedCount: 0,
    displayedMaxCount: 10,
    unclickedMaxCount: 10,
    isGameStarted: false,
    imageInterval: null,
    imageClass: 'pokemon-game-image',
    route_name: 'synolia_pokemon_get_images',

    constructor: function PokemonGameView(options) {
        PokemonGameView.__super__.constructor.call(this, options);
    },

    /**
     * @inheritdoc
     */
    initialize(options) {
        this.options = $.extend(true, {}, this.options, options);

        if (_.isMobile()) {
            this.displayedMaxCount = 5;
            this.unclickedMaxCount = 5;
        }

        $(this.elem.startGameButton).click(this.startGame.bind(this));
        $(this.elem.stopGameButton).click(this.stopGame.bind(this));
    },

    startGame() {
        if (this.isGameStarted) {
            return; // Prevent starting the game multiple times
        }
        this.isGameStarted = true;

        $.ajax({
            type: 'GET',
            url: routing.generate(this.route_name, {}),
            success: _.bind(this.onFetchPokemonsSuccess, this)
        });
    },

    onFetchPokemonsSuccess: function(response) {
        if (response.success && response.images) {
            this.imageUrls = response.images;

            // start/stop buttons
            $(this.elem.startGameButton).prop('disabled', true);
            $(this.elem.startGameButton).css({
                display: 'none'
            });
            $(this.elem.stopGameButton).prop('disabled', false);
            $(this.elem.stopGameButton).css({
                display: 'block'
            });

            // score
            this.score = 0;
            $(this.elem.scoreDisplay).text(this.score);

            // game area
            $(this.elem.gameArea).css({
                display: 'block'
            });

            //start generating pokemons
            this.imageInterval = setInterval(this.createImage.bind(this), 1500);
        } else {
            response.message && mediator.execute('showFlashMessage', 'error', response.message);
            this.isGameStarted = false;
        }
    },

    stopGame() {
        if (this.isGameStarted) {
            clearInterval(this.imageInterval);
            $(this.elem.gameArea).css({
                display: 'none'
            });

            $(this.elem.stopGameButton).prop('disabled', true);
            $(this.elem.stopGameButton).css({
                display: 'none'
            });
            $(this.elem.startGameButton).prop('disabled', false);
            $(this.elem.startGameButton).css({
                display: 'block'
            });

            $('.' + this.imageClass).remove();

            this.displayedCount = 0;
            this.unclickedCount = 0;
            // score = 0;
            // scoreDisplay.text(score); // Reset the score to zero

            this.isGameStarted = false;
        }
    },

    getRandomPosition() {
        let containerWidth = $(this.elem.gameArea).width();
        let containerHeight = $(this.elem.gameArea).height();
        let imageWidth = 100;
        let imageHeight = 100;

        let posX = Math.floor(Math.random() * (containerWidth - imageWidth));
        let posY = Math.floor(Math.random() * (containerHeight - imageHeight));

        return { x: posX, y: posY };
    },

    getRandomImageUrl() {
        let randomIndex = Math.floor(Math.random() * this.imageUrls.length);
        return this.imageUrls[randomIndex];
    },

    createImage() {
        if (!this.isGameStarted) {
            return;
        }

        if (this.displayedCount >= this.displayedMaxCount && this.unclickedCount >= this.unclickedMaxCount) {
            // Stop creating new images if the displayed count and unclicked count exceed the thresholds
            return;
        }

        let imageUrl = this.getRandomImageUrl();
        let image = $('<button class="' + this.imageClass + ' confetti-button"><img src="' + imageUrl + '"></button>');
        let position = this.getRandomPosition();

        image.css({
            left: position.x + 'px',
            top: position.y + 'px'
        });
        image.data('isProcessingClick', false);

        let self = this;
        image.click(function() {
            if ($(this).data('isProcessingClick')) {
                return;
            }
            $(this).data('isProcessingClick', true);

            // add confetti animation
            $(this).addClass('animate');

            // score label and animation
            let scoreLabel = $('<div class="pokemon-score-label">+1</div>');
            let leftPos = parseInt($(this).css('left'), 10) + $(this).width() / 2 - 9;
            let topPos = parseInt($(this).css('top'), 10) + $(this).height() / 2 - 11;
            scoreLabel.css({
                left: leftPos + 'px',
                top: topPos + 'px'
            });
            $(this).after(scoreLabel);

            let scoreOffset = $(self.elem.scoreDisplay).offset();
            let animationProps = {
                top: scoreOffset.top,
                left: scoreOffset.left
            };

            scoreLabel.delay(500).animate(animationProps, 500, function() {
                scoreLabel.fadeOut('fast', function() {
                    scoreLabel.remove();
                    self.score++;
                    $(self.elem.scoreDisplay).text(self.score);
                });
            });

            // remove pokemon
            $(this).delay(500).fadeOut('fast', function() {
                $(this).remove();
                $(this).data('isProcessingClick', false);
                self.unclickedCount--;
            });
        });

        $(this.elem.gameArea).append(image);

        this.displayedCount++;
        this.unclickedCount++;
    },
});

export default PokemonGameView;
