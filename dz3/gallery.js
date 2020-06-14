$( document ).ready( function() {

    var IMS = new Array();
    var NMS = new Array();

    var slike = new Array();
    var slika, temp_slika;
    var opisi = new Array();
    var br_gradova = $("h1").length;
    
    $(".gallery").hide();

    for (var i = 0; i < br_gradova; i++){
        var btn = $( "<button>Pogledaj galeriju!</button>" )
            .attr('id', i)
            .on("click", f);
        $("h1").eq(i).after(btn).after("Pogledaj galeriju slika. ");
    }


    var okvir = $('<div id ="okvir"></div>');
    okvir.css("position","absolute").css("top","10%").css("left","10%").css("height","80%")
        .css("width","80%").css("text-align","center").css("background-color", "black").hide();
    
    var broj = $('<p id = "broj"></p>').css("position","inherit").css("left", "48%").css("bottom","5%").css("color","white"); 
    
    var opis = $('<p id = "opis"></p>').css("position","inherit").css("left", "45%").css("bottom","1%").css("color","white"); 
    
    var x = $('<button>X</button>').on("click", X).css("position","absolute").css("width","6%").css("height", "8%").css("font-size","100%").css("border","none")
        .css("background-color","red").css("top","0%").css("right","0%").css("color","white");
    
    var lijevo = $("<button> << </button>").on("click",livo).css("position","absolute").css("width","5%").css("height", "6%").css("font-size","120%")
        .css("left","5%").css("bottom","5%").css("background-color","green").css("border","none").css("color","white");
    
    var desno = $("<button> >> </button>").on("click",desno).css("position","absolute").css("width","5%").css("height", "6%").css("font-size","120%")
        .css("right","5%").css("bottom","5%").css("background-color","green").css("border","none").css("color","white");
    
    okvir.append(x);
    okvir.append(lijevo);
    okvir.append(desno);
    okvir.append(broj);
    okvir.append(opis);
    $("body").append(okvir);

    var boxh = Number(0.82) * Number(okvir.height());
    var boxw = Number(0.82) * Number(okvir.width());

    function X(){
        $("#okvir").hide();
        temp_slika.hide();
    }

    function f(){

        var id = $(this).attr('id');
            
        // Ako smo vec bili učitali tu galeriju sad je samo loadamo 
        // da ne moramo ponovo appendat sve
        if (IMS.hasOwnProperty(id)){
            slike = IMS[id];
            opisi = NMS[id];
            temp_slika = slike[0];

            slike[0].show();
            $("#broj").html("Slika 1/" + slike.length);
            $("#opis").html(opisi[0]);
            okvir.show();
        }
        else {
            slike.length = 0;
            opisi.length = 0; 
            
            children = $("div.gallery").eq(id).children()
            
            for (var i = 0; i < children.length; i++)
                if (children.eq(i).is("img")){
                    slike.push(children.eq(i).clone());
                }
            var zeta = 0;
            while (opisi.length != slike.length){
                for (var i = 0; i < children.length; i++)
                    if (children.eq(i).is("p") && children.eq(i).attr("data-target") === slike[zeta].attr("src")){
                        opisi.push(children.eq(i).html());
                        zeta++;
                        break;
                    }
            }

            NMS[id] = new Array(opisi.length);
            IMS[id] = new Array(slike.length);

            IMS[id] = slike.map((p) => p);
            NMS[id] = opisi.map((p) => p);

            for (var j = 0; j < slike.length; j++){
                slika = slike[j];
                var h = Number(slika.prop("naturalHeight"));
                var w = Number(slika.prop("naturalWidth"));
                var pad =1.5*w/h  ;

                var max = (h/boxh > w/boxw) ? h/boxh : w/boxw;
                
                slika.css("position", "center").css("padding", pad +"%")
                .css("max-height", "80%").css("width", "auto").css("max-width", "85%");

                if (j == 0){
                    slika.show();
                    temp_slika = slika;
                }
                else
                    slika.hide()
                
                okvir.append(slika);
            }

            $("#broj").html("Slika 1/" + slike.length);
            $("#opis").html(opisi[0]);
            okvir.show();
        }
    }
    function livo(){
        for (var i = 1; i < slike.length; i++){
            if (slike[i] === temp_slika){
                slike[i].hide();
                slike[i-1].show();
                
                temp_slika = slike[i-1];
                $("#broj").html("Slika " + i + "/" + slike.length);
                $("#opis").html(opisi[i-1]);
                break;
            }
        }
    }
    function desno(){
        for (var k = 0; k < slike.length - 1; k++){
            if (slike[k] === temp_slika){
                slike[k].hide();
                slike[k+1].show();
                
                temp_slika = slike[k+1];
                $("#broj").html("Slika " + (k+2) + "/" + slike.length);
                $("#opis").html(opisi[k+1]);
                break;
            }
        }
    }
})
