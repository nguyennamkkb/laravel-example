<template>
  <card class="text-center">
    <h3 class="mb-4">
      {{ $t('page_not_found') }}
    </h3>

    <div class="links">
      
    </div>
  </card>
</template>

<script>
export default {
  name: 'NotFound',
  created(){
    // this.$router.push({ name: 'welcome' })
  }
}
</script>
