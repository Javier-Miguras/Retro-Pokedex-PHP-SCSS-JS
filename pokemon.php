<?php 

    //Go to id 

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /');
    }


    //Import conection

    require 'includes/config/database.php';
    $db = conectDB();

    //Consultar Pokemons

    $query = "SELECT * FROM pokemons WHERE id = {$id}";

    //Obtener resutados

    $result = mysqli_query($db, $query);

    if(!$result->num_rows){
        header('Location: /');
    }

    $pokemon = mysqli_fetch_assoc($result);

    //Consultar tipos

    $query_types = "SELECT types.type FROM pokemon_types
    INNER JOIN types ON pokemon_types.type_id = types.id
    WHERE pokemon_types.pokemon_id = {$id}";

    // Obtener resultados
    $result_types = mysqli_query($db, $query_types);

    if(!$result_types->num_rows){
        header('Location: /');
    }

    require 'includes/functions.php';
    includeTemplate('header');

?>


<section class="container">
    <div class="pokedex">
       <div class="poke-page">
            <div class="pokedex-img">
                <img src="img/sprites/<?php echo $pokemon['image']; ?>.png" alt="pokemon">
            </div>
            <div class="pokedex-info">
                <div class="pokedex-name">
                    <p><span> <?php echo $pokemon['name']; ?> </span></p>
                    <p>Number: <?php echo $pokemon['id']; ?> </p>
                </div>
                <div class="pokedex-extra">
                    <p>Height: <?php echo $pokemon['height']; ?> m</p>
                    <p>Weight: <?php echo $pokemon['weight']; ?> kg</p>
                </div>
                
                
            </div>
            <div class="pokedex-description">
                <p> <?php echo $pokemon['description']; ?> </p>
                <hr/>
                <div class="poke-type">
                    <p>Type:</p>
                    <?php while($type = mysqli_fetch_assoc($result_types)): ?>
                    <h3 class="type-1 <?php echo $type['type'] ?>"><?php echo $type['type'] ?></h3>
                    <?php endwhile; ?>
                </div>
            </div>
       </div>
       <a href="/index.php" class="btn btn-secondary">Back</a>
    </div>
</section>



<?php 

    includeTemplate('footer');

?>