<template>
  <main class="content-wrapper">
      <h3 class="text-center text-info h1 text-uppercase calendario text-bold pt-4">Calendario Académico     </h3>
      <div class="container-fluid pt-5 ">
            <YearCalendar 
    v-model="year"
    :activeDates.sync ="activeDates"
    @toggleDate="toggleDate"
    lang="es"
    :showYearSelector="showYearSelector"
  ></YearCalendar>
      </div>
  </main>
</template>

<script>
import YearCalendar from 'vue-material-year-calendar'

export default {
  components: { YearCalendar },
  data () {
    return {
      year: 2019,
      activeDates: [],
      showYearSelector: true
    }
  },
  methods: {
    toggleDate (dateInfo) {
      console.log(dateInfo)  // { date: '2010-10-23', selected: true }
    }
  }
}
</script>
<style >
    .calendario{
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif
    }
</style>