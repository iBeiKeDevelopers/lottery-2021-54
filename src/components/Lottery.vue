<template>
  <div class="container" :class="step3?'step3':''">
    <div class="number-wrapper g1">
      <Number :ref="i" v-for="i in 5" :key="i" :source="dataSource" @change="onChange" @reset="onReset"
              :excepts="excepts" @ok="onOK"/>
    </div>
    <div class="number-wrapper g2">
      <Number :ref="i+5" v-for="i in 5" :key="i" :source="dataSource" @change="onChange" @reset="onReset"
              :excepts="excepts" @ok="onOK"/>
    </div>
    <div class="btn start" :class="showBtn && !start? '': 'hidden'" @click="begin(1, true)">开始</div>
    <div class="btn save" :class="showBtn && start && !step3 ? '': 'hidden'" @click="save">下轮</div>
    <div class="btn save" :class="showBtn && start && step3 ? '': 'hidden'" @click="final">结束</div>
    <div class="btn start" :class="running ? '': 'hidden'" @click="stop(1, true)">停止</div>
  </div>
</template>

<script>
import Number from "./Number"
import axios from 'axios'

export default {
  name: "Lottery",
  components: {Number},
  data() {
    return {
      step3: this.$route.query.s3 !== undefined,
      old_result: [],
      result: [],
      counter: 0,
      showBtn: true,
      start: false,
      running: false,
      dataSource: []
    }
  },
  watch: {
    step3: {
      handler(newValue) {
        if (newValue) {
          this.fetchData()
        }
      },
      immediate: true
    }
  },
  computed: {
    excepts() {
      return [...this.old_result, ...this.result]
    }
  },
  methods: {
    fetchData() {
      axios.get('./data.json').then(res => {
        const data = []
        for (let i of res.data) {
          i = String(i)
          if (i.length === 11) {
            data.push(i)
          }
        }
        this.dataSource = res.data
      })
    },
    stop(i, c) {
      if (!this.running && c)
        return
      this.running = false
      this.$refs[i][0].stop()
      if (i === 10) {
        return
      }
      setTimeout(() => {
        this.stop(i + 1)
      }, 5)
    },
    begin(i, c) {
      if (!this.showBtn && c)
        return
      this.showBtn = false
      this.$refs[i][0].begin()
      if (i === 10) {
        this.start = true
        this.running = true
        return
      }
      setTimeout(() => {
        this.begin(i + 1)
      }, 30)
    },
    save() {
      if (!this.showBtn)
        return
      const {result} = this
      this.$emit('ok', [...result])
      this.old_result.push(...result)
      for (let i = 1; i <= 10; i++) {
        this.$refs[i][0].reset()
      }
      this.start = false
      console.log(this.old_result.length)
      if (this.old_result.length === 20) {
        this.step3 = true
      }
    },
    onChange(n) {
      this.result.push(n)
    },
    onReset(n) {
      const r = []
      for (const i of this.result) {
        if (i !== n)
          r.push(i)
      }
      this.result = r
    },
    onOK() {
      this.counter += 1
      if (this.counter === 10) {
        this.counter = 0
        this.showBtn = true
      }
    },
    final() {
      alert(`抽奖结果
      第一轮: ${this.old_result.slice(0, 10)}
      第二轮: ${this.old_result.slice(10, 20)}
      第三轮: ${JSON.stringify(this.result).replaceAll('"', '')},
      `)
    }
  }
}
</script>

<style lang="sass" scoped>

.container
  display: flex
  flex-direction: column
  align-items: center

.btn
  font-family: "HYXINHAIXINGKAI", sans-serif
  display: flex
  justify-content: center
  align-items: center
  height: 6.78vh
  width: 14.29vh
  background-image: url("../assets/image/btn.png")
  background-size: contain
  position: absolute
  left: 64.42vh
  top: 89vh
  cursor: pointer
  font-size: 3.6vh
  letter-spacing: 4px
  font-weight: bolder
  transform: translateY(0)
  opacity: 1

  &.hidden
    transition: 0.15s all ease-in-out
    transform: translateY(80%)
    opacity: 0

.btns.hidden .btn
  cursor: default

.number-wrapper
  display: flex
  flex-direction: column
  align-items: flex-start
  justify-content: space-between
  width: 31vh
  height: 68.4vh
  margin: auto
  position: absolute
  top: 18.32vh

  &.g1
    left: 8vh

    & > div:nth-child(even)
      align-self: flex-end

  &.g2
    left: 104vh

    & > div:nth-child(odd)
      align-self: flex-end

</style>
