<template>
  <div id="app">
    <img alt="" class="bg" src="./assets/image/btn-bg.png">
    <main>
      <div class="title">
        第{{ result.length + 1 }}轮
      </div>
      <Lottery @ok="onOK"/>
    </main>
  </div>
</template>

<script>
import Lottery from "./components/Lottery"

export default {
  name: 'App',
  components: {
    Lottery
  },
  data() {
    return {
      result: [],
    }
  },
  methods: {
    onOK(items) {
      this.result.push(items)
    }
  }
}
</script>

<style lang="sass" scoped>
@import "./assets/fonts/xk/HYXINHAIXINGKAI-embed.css"
main
  width: 100%
  height: 100%
  position: absolute
  left: 0
  top: 0

#app
  font-family: Avenir, Helvetica, Arial, sans-serif
  -webkit-font-smoothing: antialiased
  -moz-osx-font-smoothing: grayscale
  position: relative
  margin: auto
  width: fit-content

.bg
  z-index: -1
  pointer-events: none
  height: 100vh

.title
  position: absolute
  display: inline
  font-size: 88px
  font-family: "HYXINHAIXINGKAI", sans-serif
  letter-spacing: 10px
  left: 93vh
  top: 5vh
  background-size: cover
  background: url("assets/image/text-bg.jpg") 26.2vh 8vh
  -webkit-background-clip: text
  color: transparent

</style>
<style>
body {
  margin: 0;
  background: #050202;
}
</style>
