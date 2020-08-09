<template>
  <div>
    <div class="pimg1">
      <div class="ptext">
        <span>Sundance Berlin</span>
      </div>
    </div>

    <section class="section section-light">
      <div>
        <p>
          <strong>Willkommen</strong> bei den Seiten von Sundance Astro Berlin, der astrologischen Beratungspraxis von Georg Stockhorst.
          <br />Hier haben Sie die Möglichkeit ein einzigartiges Astrologisches Beratungsangebot kennen zu lernen.
          <br />Einige Themen, die auf dieser Website vorgestellt werden finden Sie so weltweit bei keinem anderen Anbieter.
          <br />Das gilt einerseits für diese besondere Form der Karmastrologie sowie der Astrologischen Psychologie und Astromedizin.
          <br />Außerdem natürlich für die Astrogeographische Standortberatung zu günstigen Adressen, Städten, Regionen weltweit
          <br />mit meinen astrologischen Stadtplänen und der Astrogeographischen Weltkarte,
          <br />die ich alle völlig unabhängig entwickelt und veröffentlicht habe.
        </p>
        <p>
          Kurze astrogeographische Deutungen für Orte können Sie übrigens 24 Stunden am Tag auf meinem Webservice
          <br />
          <a href="http://www.astrogeomantie.de/" target="_blank">astrogeography.com</a> kostengünstig online selbst erstellen.
        </p>
      </div>
    </section>

    <div class="pimg2"></div>

    <section class="section section-light">
      <div>
        <h6 class="text-center">sundance shop</h6>
        <p>
          Astrologische Landkarten und Stadtpläne
          <br />Zahlreiche Texte und Fotos
          <br />Deutungsanleitung mit der auch Laien den Stadtplan selber deuten können
          <br />Bestellungen auch per email an: astrogeographie@email.de
        </p>
        <div class="maps-div">
          <div class="row">
            <div class="col mapH">
              <img src="/img/home-maps/berlin.jpg" />
              <div class="map-capt">Preis 9.80 €</div>
            </div>
            <div class="col mapH">
              <img src="/img/home-maps/koeln.jpeg" />
              <div class="map-capt">Preis 11.80 €</div>
            </div>
            <div class="col mapH">
              <img src="/img/home-maps/muenchen.jpeg" />
              <div class="map-capt">Preis 9.80 €</div>
            </div>
          </div>
          <div class="row">
            <div class="col mapH">
              <img src="/img/home-maps/wien.jpeg" />
              <div class="map-capt">Preis 13.20 €</div>
            </div>
            <div class="col mapH">
              <img src="/img/home-maps/deutschland.jpeg" />
              <div class="map-capt">Preis 21.000 €</div>
            </div>
            <div class="col mapH">
              <img src="/img/home-maps/oes-sbayern.jpg" />
              <div class="map-capt">Preis 11.50 € (D)</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="pimg3"></div>

    <section class="card" data-aos="fade-left" data-aos-duration="1200">
      <img src="/img/pages/buddha.png" alt="fade-left" />
      <div class="text-left">
        <h6 class="text-center">Karma Horoskop</h6>
        <p>
          Im Karmahoroskop geht es um die astrologische Deutung des individuellen Sinns des Lebens und die Frage:
          <br />warum wurde ich geboren?
          <br />Ziel der Beratung ist es, die eigenen Entwicklungsthemen, Verhaltensmuster, Glaubenssätze, Prägungen besser zu verstehen
          <br />Mit schwierigen Themen besser umzugehen und unsere Lebensthemen als natürliche Anlagen und Entwicklungsituationen einzuordnen
          <br />Karma, Reinkarnation, Spiritualität und Persönlichkeitsentwicklung aus der Sicht der astrologischen Psychologie zu betrachten kann helfen,
          <br />das wir uns mit schwierigen Themen leichter tun und auch unsere eigenen Potentiale besser aushalten.
        </p>
      </div>
    </section>

    <section class="card" data-aos="fade-right" data-aos-duration="1200">
      <img src="/img/pages/human.png" alt="fade-left" />
      <div class="text-left">
        <h6 class="text-center">Astromedizin Horoskop</h6>
        <p>
          Beim Astromedizin Horoskop geht es um die ganzheitliche Deutung der Zusammenhänge von
          <br />psychosomatischen, mentalen, physischen, karmischen und spirituellen Krankheitsursachen aus astrologischer Sicht
          <br />Service auch für Heilberufe.
        </p>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  // use body.home css style from App.vue only for this page to solve aos overflow-x issue
  beforeCreate: function() {
    document.body.className = "home";
  },
  data() {
    return {};
  },
  methods: {},
  created() {
    $(window).scroll(() => {
      let wScroll = $(window).scrollTop();
      // if maps-div reach top of window, $(".maps-div").offset().top
      // substract else efect is late to see
      if (wScroll > $(".maps-div").offset().top - $(window).height() / 1.2) {
        $(".maps-div .mapH").each(i => {
          setTimeout(() => {
            $(".maps-div .mapH")
              .eq(i)
              .addClass("is-showing");
          }, 150 * (i + 1));
        });
        console.log("hi");
      }
    });
  }
};
</script>

<style lang="scss" scoped>
.pimg1,
.pimg2,
.pimg3 {
  position: relative;
  opacity: 0.9;
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
  width: 100%;
  /*
    fixed = parallax
    scroll = normal
  */
  background-attachment: fixed;
}
.pimg1 {
  background-image: url("/img/pages/bckgr-1.jpg");
  height: 500px;
}
.pimg2 {
  background-image: url("/img/pages/bckgr-2.jpg");
  height: 300px;
}
.pimg3 {
  background-image: url("/img/pages/bckgr-3.jpg");
  height: 300px;
}

.section {
  text-align: center;
  padding: 50px 80px;
}
.mapH {
  padding-top: 30px;
  width: 100%;
  height: auto;
  opacity: 0;
  transform: translateX(-20px);
  transition: all 0.4s ease-in-out;
}
// class to show maps
.is-showing {
  opacity: 1 !important;
  transform: translateX(0px);
}
// zoom maps
.mapH img {
  transform: scale(1);
  transition: all 0.3s ease-in-out;
}
.mapH .map-capt {
  margin-top: 10px;
}

// zoom maps
.mapH:hover {
  img {
    transform: scale(1.1);
    cursor: pointer;
  }
}

.section-light {
  background-color: #f4f4f4;
  color: #666;
}

.ptext {
  position: absolute;
  top: 50%;
  width: 100%;
  text-align: center;
  color: white;
  font-size: 27px;
  letter-spacing: 8px;
}

.card {
  display: grid;
  grid-template-columns: 1fr 3fr;
  grid-gap: 10px;
  margin-top: 10px;
  background-color: lightgray;

  img {
    max-width: 100%;
    max-height: 100%;
  }
  div {
    line-height: 1.6;
    h6 {
      margin-top: 20px;
      margin-bottom: 10px;
    }
    p {
      padding: 10px;
    }
  }
}

/* 
@media (max-width: 568px) {
  .pimg1,
  .pimg2,
  .pimg3 {
    background-attachment: scroll;
  } 
} */
</style>
