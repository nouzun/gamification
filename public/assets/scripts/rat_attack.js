
var game = new Phaser.Game(800, 400, Phaser.CANVAS, 'phaser-example', { preload: preload, create: create, update: update });
var player;
function preload() {
    game.load.bitmapFont('gem', 'assets/fonts/bitmapFonts/gem.png', 'assets/fonts/bitmapFonts/gem.xml');
}

function create() {

    game.physics.startSystem(Phaser.Physics.ARCADE);

    game.stage.backgroundColor = '#2d2d2d';

    //  These sprites were created with the Phaser Gen Paint app
    //  also available in the Phaser Examples repo and on the Phaser site.

    var endData = [
        '2222'
    ];

    game.create.texture('endTexture', endData, 1, 1, 1);

    var ratData = [
        '.D...........',
        '18...........',
        '1D...........',
        '18.....1111..',
        '1D..111DDEE1.',
        '1811EEE18E0E1',
        '.1DEEEEEEEEED',
        '..1EEEEEE41..',
        '.11E41E1411..',
        '1111E1E1E111.',
        '.1111111111..'
    ];

    game.create.texture('ratTexture', ratData, 4, 4, 4);

    var dudeData = [
        '.......3.....',
        '......333....',
        '....5343335..',
        '...332333333.',
        '..33333333333',
        '..37773337773',
        '..38587778583',
        '..38588888583',
        '..37888888873',
        '...333333333.',
        '.F....5556...',
        '3E34.6757.6..',
        '.E.55.666.5..',
        '......777.5..',
        '.....6..7....',
        '.....7..7....'
    ];

    game.create.texture('phaserDude', dudeData, 4, 4, 0);

    //  Now we've got our textures let's just make some sprites

    var end = game.add.sprite(0, 400-64, 'endTexture');
    end.width = 800;
    end.height = 64;

    rats = game.add.physicsGroup();

    var y = 30;

    for (var i = 0; i < 9; i++)
    {
        var rat = rats.create(game.rnd.between(10, 250), y, 'ratTexture');
        //rat.body.velocity.x = game.rnd.between(100, 300);
        y += 40;
    }

    player = game.add.sprite(700, 150, 'phaserDude');
    player.anchor.set(0.5);

    game.physics.arcade.enable(player);

    cursors = game.input.keyboard.createCursorKeys();

}

function update() {

    rats.forEach(checkPos, this);

    game.physics.arcade.overlap(player, rats, collisionHandler, null, this);

    player.body.velocity.x = 0;
    player.body.velocity.y = 0;

    if (cursors.left.isDown)
    {
        player.body.velocity.x = -200;
        player.scale.x = 1;
        rats.forEach(moveRat, this);
    }
    else if (cursors.right.isDown)
    {
        player.body.velocity.x = 200;
        player.scale.x = -1;
        rats.forEach(moveRat, this);
    }

    if (cursors.up.isDown)
    {
        player.body.velocity.y = -200;
    }
    else if (cursors.down.isDown)
    {
        player.body.velocity.y = 200;
    }

}

function moveRat(rat) {
    //rat.body.velocity.x = game.rnd.between(100, 300);
    game.physics.arcade.moveToObject(rat, player, 300);
}

function checkPos (rat) {

    if (rat.x > 800)
    {
        rat.x = -100;
    }
    rat.body.velocity.x = 0;
    rat.body.velocity.y = 0;
}

function collisionHandler (player, rat) {

    //player.x = 20;
    //player.y = 150;

    game.add.bitmapText(32, 128, 'gem', "You've eaten by rats!", 32);
    //game.lockRender = true;
    //game.destroy();
}
