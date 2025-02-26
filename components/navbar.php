<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-0 pe-5">
    <a href="index.php" class="navbar-brand ps-5 me-0" style="background-color:grey; padding: 10px 30px; border-radius: 5px;">
       <img class="brand-logo" alt="Chameleon admin logo" src="img/cinema.png"   style="width: 190px; height: auto; position: relative; top: -10px;"/>
    </a>

    <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
            <a href="upcoming.php" class="nav-item nav-link <?php echo ($current_page == 'upcoming.php') ? 'active' : ''; ?>">Upcoming</a>
            <a href="theater.php" class="nav-item nav-link <?php echo ($current_page == 'theater.php') ? 'active' : ''; ?>">Theater</a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo ($current_page == 'usia.php?usia=SU' || $current_page == 'usia.php?usia=13' || $current_page == 'usia.php?usia=SU') ? 'active' : ''; ?>" data-bs-toggle="dropdown">Usia</a>
                <div class="dropdown-menu bg-light m-0">
                    <a href="usia.php?usia=SU" class="dropdown-item">SU</a>
                    <a href="usia.php?usia=13" class="dropdown-item">13</a>
                    <a href="usia.php?usia=SU" class="dropdown-item">17</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo ($current_page == 'genre.php') ? 'active' : ''; ?>" data-bs-toggle="dropdown">Genre</a>
                <div class="dropdown-menu bg-light m-0" style="max-height: 300px; overflow-y: auto; width: 250px;">
                    <a href="genre.php?genre=Action" class="dropdown-item">Action</a>
                    <a href="genre.php?genre=Adventure" class="dropdown-item">Adventure</a>
                    <a href="genre.php?genre=Animation" class="dropdown-item">Animation</a>
                    <a href="genre.php?genre=Biography" class="dropdown-item">Biography</a>
                    <a href="genre.php?genre=Cartoon" class="dropdown-item">Cartoon</a>
                    <a href="genre.php?genre=Comedy" class="dropdown-item">Comedy</a>
                    <a href="genre.php?genre=Crime" class="dropdown-item">Crime</a>
                    <a href="genre.php?genre=Disaster" class="dropdown-item">Disaster</a>
                    <a href="genre.php?genre=Documentary" class="dropdown-item">Documentary</a>
                    <a href="genre.php?genre=Drama" class="dropdown-item">Drama</a>
                    <a href="genre.php?genre=Epic" class="dropdown-item">Epic</a>
                    <a href="genre.php?genre=Erotic" class="dropdown-item">Erotic</a>
                    <a href="genre.php?genre=Experimental" class="dropdown-item">Experimental</a>
                    <a href="genre.php?genre=Family" class="dropdown-item">Family</a>
                    <a href="genre.php?genre=Fantasy" class="dropdown-item">Fantasy</a>
                    <a href="genre.php?genre=Film-Noir" class="dropdown-item">Film-Noir</a>
                    <a href="genre.php?genre=History" class="dropdown-item">History</a>
                    <a href="genre.php?genre=Horror" class="dropdown-item">Horror</a>
                    <a href="genre.php?genre=Martial+Arts" class="dropdown-item">Martial Arts</a>
                    <a href="genre.php?genre=Music" class="dropdown-item">Music</a>
                    <a href="genre.php?genre=Musical" class="dropdown-item">Musical</a>
                    <a href="genre.php?genre=Mystery" class="dropdown-item">Mystery</a>
                    <a href="genre.php?genre=Political" class="dropdown-item">Political</a>
                    <a href="genre.php?genre=Psychological" class="dropdown-item">Psychological</a>
                    <a href="genre.php?genre=Romance" class="dropdown-item">Romance</a>
                    <a href="genre.php?genre=Sci-Fi" class="dropdown-item">Sci-Fi</a>
                    <a href="genre.php?genre=Sport" class="dropdown-item">Sport</a>
                    <a href="genre.php?genre=Superhero" class="dropdown-item">Superhero</a>
                    <a href="genre.php?genre=Survival" class="dropdown-item">Survival</a>
                    <a href="genre.php?genre=Thriller" class="dropdown-item">Thriller</a>
                    <a href="genre.php?genre=War" class="dropdown-item">War</a>
                    <a href="genre.php?genre=Western" class="dropdown-item">Western</a>
                </div>
            </div>


            <!-- Form Pencarian -->
            <form class="d-flex ms-3 me-4 align-items-center">
                <div class="relative w-full max-w-md">
                    <input type="text" id="searchMovie" class="w-full p-2 border rounded">
                    <ul id="movieResults" class="hidden"></ul>
                </div>


            </form>

            <!-- Hasil pencarian -->
            </ul>
            <style>
                #movieResults li {
                    padding: 10px;
                    cursor: pointer;
                    transition: background 0.2s;
                    display: flex;
                    align-items: center;
                }

                /* Hover effect */
                #movieResults li:hover {
                    background: #f1f1f1;
                }

                #movieResults {
                    position: absolute;
                    top: 100%;
                    left: 50rem;
                    /* Dropdown mulai dari kiri input */
                    width: 100%;
                    /* Lebar dropdown sama dengan input */
                    max-width: 300px;
                    /* Atur supaya nggak terlalu lebar */
                    background-color: white;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                    z-index: 1000;
                    max-height: 200px;
                    overflow-y: auto;
                }
            </style>

            <script>
                const searchInput = document.getElementById("searchMovie");
                const resultsList = document.getElementById("movieResults");

                searchInput.addEventListener("input", function() {
                    const query = this.value.trim();
                    resultsList.innerHTML = "";

                    if (query.length > 0) {
                        fetch(`get_movies.php?q=${query}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    resultsList.classList.remove("hidden"); // Tampilkan dropdown
                                    resultsList.innerHTML = ""; // Hapus hasil lama

                                    data.forEach(movie => {
                                        const li = document.createElement("li");
                                        li.textContent = movie.nama_film;
                                        li.className = "p-2 hover:bg-blue-100 cursor-pointer transition-all duration-200";

                                        li.onclick = () => {
                                            window.location.href = `film.php?id=${movie.id}`;
                                        };

                                        resultsList.appendChild(li);
                                    });
                                } else {
                                    resultsList.classList.add("hidden"); // Sembunyikan kalau kosong
                                }
                            })
                            .catch(error => console.error("Error fetching data:", error));
                    } else {
                        resultsList.classList.add("hidden");
                    }
                });

                document.addEventListener("click", function(e) {
                    if (!searchInput.contains(e.target) && !resultsList.contains(e.target)) {
                        resultsList.classList.add("hidden");
                    }
                });
            </script>

        </div>
        <?php if (isset($_SESSION['name'])): ?>
            <div class="nav-item dropdown">
                <a href="#" class="btn btn-primary px-3 d-none d-lg-flex align-items-center dropdown-toggle"
                    style="background-color:grey; border-color: grey; color: white;"
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user me-2"></i> <?php echo $_SESSION['name']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">

                    <li><a class="dropdown-item" href="riwayat.php?username=<?php echo $_SESSION['email']; ?>">Riwayat</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary px-3 d-none d-lg-flex align-items-center"
                style="background-color:grey; border-color:grey; color: white;">
                <i class="fas fa-user me-2"></i> Login
            </a>
        <?php endif; ?>
    </div>
</nav>