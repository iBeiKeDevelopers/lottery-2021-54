<template>
  <div class="n" @dblclick="show ? ()=>{begin();console.log(1)}:null">
    <div class="wrapper">
      <div class="full" :class="[roll ? 'roll': '', s?'stop':'']">
        <div class="each" v-for="(i,index) in items" :key="index">
          {{ typeof i === "number" ? i : i.substring(0, 5) + '**' + i.substring(7, 11) }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "Number",
  props: {
    excepts: {
      default: () => [],
      type: Array
    },
    source: {
      default: () => [],
      type: Array
    }
  },
  data() {
    return {
      show: false,
      start: false,
      roll: false,
      items: [0],
      dataSource: null,
      s: true
    }
  },
  watch: {
    source(value) {
      if (value.length) {
        this.dataSource = value
      }
    }
  },
  methods: {
    stop() {
      this.s = true
    },
    begin() {
      this.start = true
      if (this.start) {
        this.reset()
        this.$nextTick(() => {
          // 应该是要用$nextTick才对，但是不符合预期，只得使用setTimeout
          setTimeout(() => {
            this.random()
          }, 20)
        })
      } else {
        this.random()
      }
    },
    random() {
      this.show = false
      const dataSource = this.dataSource ?? [...Array(1200).keys()]
      let arr = dataSource.filter(i => this.excepts.indexOf(i) === -1);
      const result = arr.sort(function () {
        return Math.random() - 0.5;
      }).slice(0, 300)
      this.$emit('change', result[result.length - 1])
      const {items} = this
      this.items = [items[0], ...result]
      this.roll = true
      this.s = false
      this.interval = setInterval(() => {
        if (this.s) {
          clearInterval(this.interval)
          setTimeout(() => {
            this.show = true
            this.$emit('ok')
          }, 30)
        }
      }, 3500)
    },
    reset() {
      const {items} = this
      if (items[items.length - 1] !== 0) this.$emit('reset', items[items.length - 1])
      if (items.length !== 1) {
        this.$set(this.items, 0, 0)
      }
      this.roll = false
    },
  }
}
</script>

<style lang="sass" scoped>
@import "../assets/fonts/lato/lato.css"
$eachHeight: 7vh
$eachWidth: 24vh
.n
  background: url("../assets/image/text-bg.jpg")
  font-family: "lato", monospace
  font-size: 50px
  font-weight: bold
  display: flex
  align-items: center
  height: $eachHeight + 4.2vh

  .wrapper
    width: $eachWidth
    height: $eachHeight
    overflow: hidden

    .full
      animation: none

    .full.roll
      transform: translateY(calc(-100% + 7vh))
      animation: move 3.5s forwards steps(200, end)
      animation-iteration-count: infinite

    .full.roll.stop
      animation-iteration-count: 1

    .each
      height: $eachHeight
      width: $eachWidth
      display: flex
      align-items: center
      justify-content: center

@keyframes move
  0%
    transform: translateY(0)
  100%
    transform: translateY(calc(-100% + 7vh))


</style>
<style>

.step3 .n {
  font-size: 3vh
}
</style>
