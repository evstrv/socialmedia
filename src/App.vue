<template>
  <div id="app">
    <Header/>
    <main>
      <Main/>
    </main>
    <Footer/>
  </div>
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue'
import Main from './pages/Main';
import Header from './components/Header';
import Footer from './components/Footer';

export default {
  name: 'App',
  components: {
    // HelloWorld,
    Main,
    Header,
    Footer
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&display=swap');

* {
  font-family: 'Roboto Condensed', sans-serif;
}

body, html {
  margin: 0;
  padding: 0;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

main {
  min-height: calc(100vh - 2 * 46px);
}
</style>
