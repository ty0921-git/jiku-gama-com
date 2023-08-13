
    <script>
        let link = document.querySelector(".thumb01");
        let image = document.querySelector("#image");
        let image_tab = document.querySelector("#image-tab");
        let tab = document.querySelectorAll("#myTab .nav-link");
        let pane = document.querySelectorAll(".tab-pane");

        link.addEventListener("click", function() {
            for (let i = 0; i < pane.length; i++) {
                pane[i].classList.remove("active", "show");
            }
            for (let i = 0; i < tab.length; i++) {
                tab[i].classList.remove("active");
            }
            image.classList.add("active", "show");
            image_tab.classList.add("active");
        });
    </script>