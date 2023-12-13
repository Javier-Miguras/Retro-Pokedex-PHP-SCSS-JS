<?php
require 'includes/functions.php';
includeTemplate('header');

require 'includes/config/database.php';
$db = conectDB();

// Consultar tipos
$queryTypes = "SELECT * FROM types";
$resultTypes = mysqli_query($db, $queryTypes);

// Obtener tipos seleccionados de la URL
$typeFilter = isset($_GET['typeFilter']) ? explode(',', $_GET['typeFilter']) : [];

// Construir la parte WHERE de la consulta SQL para filtrar por tipos
$whereClause = '';
if (!empty($typeFilter)) {
    $whereClause = " WHERE t.type IN ('" . implode("','", $typeFilter) . "')";
}

// Consultar Pokémon con filtro de tipos
$query = "SELECT DISTINCT p.* FROM pokemons p
          LEFT JOIN pokemon_types pt ON p.id = pt.pokemon_id
          LEFT JOIN types t ON pt.type_id = t.id"
          . $whereClause;

// Verificar si se ha enviado algún filtro de orden o establecer predeterminado
$sortFilter = isset($_GET['sortFilter']) ? $_GET['sortFilter'] : 'lowest';

// Filtrar solo los elementos necesarios en la URL
$filteredParams = http_build_query(['sortFilter' => $sortFilter, 'typeFilter' => implode(',', $typeFilter)]);

// Aplicar orden según el filtro seleccionado
switch ($sortFilter) {
    case 'highest':
        $query .= " ORDER BY p.id DESC";
        break;
    case 'az':
        $query .= " ORDER BY p.name ASC";
        break;
    case 'za':
        $query .= " ORDER BY p.name DESC";
        break;
    // Por defecto, ordenar por el número más bajo
    default:
        $query .= " ORDER BY p.id ASC";
}

// Ejecutar la consulta actualizada
$result = mysqli_query($db, $query);

?>

<section class="container">
    <div class="pokedex">
        <div class="pokedex-options">
            <div class="filter-options">
                <label for="typeFilter">Filter By</label>
                <button value="type" id="openModalButton" class="btn-filter">Type</button>
            </div>

            <div class="sort-options">
                <label for="sortFilter">Sort By</label>
                <select name="sortFilter" id="sortFilter">
                    <option value="lowest" <?php echo ($sortFilter === 'lowest') ? 'selected' : ''; ?>>Lowest Number (First)</option>
                    <option value="highest" <?php echo ($sortFilter === 'highest') ? 'selected' : ''; ?>>Highest Number (First)</option>
                    <option value="az" <?php echo ($sortFilter === 'az') ? 'selected' : ''; ?>>A-Z</option>
                    <option value="za" <?php echo ($sortFilter === 'za') ? 'selected' : ''; ?>>Z-A</option>
                </select>
            </div>
        </div>
        <div class="pokedex-list">
            <ul id="pokemonList">
                <?php while ($pokemon = mysqli_fetch_assoc($result)): ?>
                    <?php
                    $pokeId;
                    if ($pokemon['id'] < 10) {
                        $pokeId = '00' . $pokemon['id'];
                    } elseif ($pokemon['id'] < 100) {
                        $pokeId = '0' . $pokemon['id'];
                    } else {
                        $pokeId = $pokemon['id'];
                    }
                    ?>
                    <li data-position="<?php echo $pokemon['id']; ?>">
                        <div class="poke-img">
                            <img src="img/sprites/<?php echo $pokemon['image']; ?>.png" alt="pokemon">
                        </div>
                        <div class="poke-info">
                            <p><span><?php echo $pokeId . ' ' ?></span><?php echo $pokemon['name']; ?></p>
                        </div>
                        <div class="poke-button">
                            <a href="/pokemon.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-primary">Info</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</section>

<dialog id="modal" class="modal">
        <div class="modal-content">
        <div class="text-align-left">
        <button id="closeModal" class="btn btn-primary"><span>Back</span></button>
        </div>
            <h2>Select Types</h2>
            <div class="types-grid">
            <?php while($type = mysqli_fetch_assoc($resultTypes)): ?>
                <h3 class="type-button btn-block <?php echo $type['type'] ?>"><?php echo $type['type'] ?></h3>
            <?php endwhile; ?>
            </div>
        </div>
        <div class="modal-button text-align-left">
            <button id="resetTypes" class="btn btn-primary"><span>Reset</span></button>
            <button id="applyTypes" class="btn btn-primary"><span>Apply</span></button>
        </div>
    </dialog>

<script src="build/js/app.js"></script>

<?php includeTemplate('footer'); ?>
