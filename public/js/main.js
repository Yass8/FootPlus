const animatedTexts = document.querySelectorAll('.anime');
const animatedTextsVert = document.querySelectorAll('.animeVert');

//
// console.log(animatedTexts);


function animateText(animatedText) {
    const text = animatedText.textContent;
    let speed = animatedText.getAttribute("speed");
    let delay = animatedText.getAttribute("delay");
    if (speed == null) {
        speed = 150;
    }
    if (delay == null) {
        delay = 0;
    }
    animatedText.innerHTML = '';
    for (let i = 0; i < text.length; i++) {
        if(text[i] == ' '){
            animatedText.innerHTML += ' ';
        }
        animatedText.innerHTML += `<span>${text[i]}</span>`;
    }

    setTimeout(function() {
        let idx = 0;
        function writeChar() {
            const span = animatedText.querySelectorAll('span')[idx];
            span.classList.add('fad');
            idx++;
            if(idx == text.length){
                clearInterval(writeCharInterval);
            }
        }

        let writeCharInterval = setInterval(writeChar, speed);
    }, delay);

    
}

animatedTexts.forEach(animateText);
animatedTextsVert.forEach(animateText);


//search

/*$(document).ready(function () {
    $('.resultatRecherche').hide();
    // $(document).on('',function)
    $('#search').keyup(function (e) { 
        e.preventDefault();
        var mot = $('#search').val();
        if (mot == "") {
            $('.resultatRecherche').hide();
        } else {
            $('.resultatRecherche').show();
            // $('#mot').html(mot);
            var datas = {
                "_token": "{{ csrf_token() }}",
                'mot' : mot,
                
            }
            $.ajax({
                type: "POST",
                url: "/search",
                data: datas,
                dataType: "json",
                success: function (response) {
                    $('#listeResultats').html("");
                    if (response.count >= 1) {
                        $('.noResultats').html("");
                        $.each(response.championnats, function(key, values) {
                            $('#listeResultats').append(`<div>
                                <h3><a href="" class="text-decoration-none text-success"><strong>${values.nom_championnat}</strong></a></h3>
                                <p>${values.nom_saison} / ${values.nom_etat} / ${values.nom_division}</p>
                            </div>`);
                        });
                    } else {
                        $('#listeResultats').html("<p class='text-center'>Aucun correspondance de votre recherche !</p>");
                    }
                }
            });
        }
    });
});*/