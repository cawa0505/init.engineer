<template>
  <div :class="{fullsize: isFullSize}">
    <label class="col-label bg-color-primary color-color-primary" @click="toggleFullsize()">YKLM 大學</label>
    <iframe class="bbsiframe" :src="termUrl" width="100%" height="100%" allowtransparency="true" frameborder="0" allow="fullscreen" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
  </div>
</template>

<script>
export default {
  name: "TerminalWindow",
  data() {
    return {
      termUrl: "https://yklm.schl.tw",
      isFullSize: false,
    }
  },
  methods: {
    toggleFullsize() {
      if (this.$screen.md) {
        this.isFullSize = !this.isFullSize
      }
    },
    normalize(e) {
      if (e.keyCode === 27) {
        this.isFullSize = false;
      }
    }
  },
  watch: {
    isFullSize() {   
      if (this.isFullSize === false) {
        window.removeEventListener("keydown", this.normalize);
      } else {
        window.addEventListener("keydown", this.normalize);
      }
    },
    '$screen.width'() {
        if ($screen.sm) {
          this.isFullSize = false;
        }
    }
  },
};
</script>
<style scoped>
.bbsiframe {
  height:calc(100vw * 0.4 - 20px);
  min-height: 300px;
}
.fullsize {
  top: 38px;
  position: fixed;
  width: 95vw;
  height: 90vh;
  z-index:99;
}
.fullsize .bbsiframe {
  height: 100%;
  width: 100%;
}
</style>