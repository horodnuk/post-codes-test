<template>
  <q-layout
    class="wrapper"
    view="hhh lpR fff"
  >
    <q-page-container class="full-width">
      <q-page padding class="content">
        <router-view/>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'DefaultLayout',
});
</script>
