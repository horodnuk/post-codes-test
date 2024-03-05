<template>
  <q-card class="q-pa-md q-mb-lg">
    <q-breadcrumbs>
      <q-breadcrumbs-el
        icon="widgets"
        label="Postal codes"
        :to="{ name: 'pages.postal_codes.all' }"
      />

      <q-breadcrumbs-el
        icon="navigation"
        label="Postal code"
      />
    </q-breadcrumbs>
  </q-card>

  <q-card
    v-if="!needShowError"
    class="q-mb-lg q-pa-md flex flex-end justify-end"
  >
    <q-btn
      color="negative"
      icon-right="delete"
      no-caps
      flat
      dense
      label="Remove"
      @click="removePostalCode"
    />
  </q-card>

  <q-card
    v-if="needShowError"
    class="q-pa-md"
  >
    Error loading postal code
  </q-card>

  <q-card
    v-else
    class="q-pa-md"
  >
    <div class="q-gutter-md">
      <div class="q-mb-mb">
        Область: <strong>{{ postalCode.region }}</strong>
      </div>

      <div class="q-mb-mb">
        Район (старий): <strong>{{ postalCode.district_old }}</strong>
      </div>

      <div class="q-mb-mb">
        Район (новий): <strong>{{ postalCode.district_new }}</strong>
      </div>

      <div class="q-mb-mb">
        Населений пункт: <strong>{{ postalCode.settlement }}</strong>
      </div>

      <div class="q-mb-mb">
        Поштовий індекс (Postal code): <strong>{{ postalCode.postal_code }}</strong>
      </div>

      <div class="q-mb-mb">
        Region (Oblast): <strong>{{ postalCode.region_eng }}</strong>
      </div>

      <div class="q-mb-mb">
        District new (Raion new): <strong>{{ postalCode.district_new_eng }}</strong>
      </div>

      <div class="q-mb-mb">
        Settlement: <strong>{{ postalCode.settlement_eng }}</strong>
      </div>

      <div class="q-mb-mb">
        Вiддiлення зв`язку: <strong>{{ postalCode.post_office }}</strong>
      </div>

      <div class="q-mb-mb">
        Post office: <strong>{{ postalCode.post_office_eng }}</strong>
      </div>

      <div class="q-mb-mb">
        Поштовий індекс відділення зв`язку (Post code of post office): <strong>{{ postalCode.postal_code }}</strong>
      </div>
    </div>
  </q-card>

</template>

<script>
import { computed, defineComponent, ref } from 'vue';

import { useQuasar } from 'quasar';
import { usePostalCodesStore } from '../stores/postal-codes-store.js';
import pinia from '../stores/index.js';
import { useRoute, useRouter } from 'vue-router';


export default defineComponent({
  name: 'PostalCodesView',

  async setup() {
    const $q = useQuasar();
    const route = useRoute();
    const router = useRouter();

    const postalCodeStore = usePostalCodesStore(pinia());

    const needShowError = ref(false);

    const result = await postalCodeStore.load(route.params.code);
    if (!result.success) {
      needShowError.value = true;
    }

    const postalCode = computed(() => postalCodeStore.getPostalCode);

    const removePostalCode = () => {
      $q.dialog({
        title: 'Confirm',
        message: 'Are you sure you want to delete the entry?',
        cancel: true,
        persistent: true
      }).onOk(async () => {
        const response = await postalCodeStore.remove(postalCode.value.post_code);

        if (!response?.success) {
          $q.notify({
            type: 'negative',
            message: 'Error remove',
            position: 'top-right',
          });
          return;
        }

        await router.push({ name: 'pages.postal_codes.all' });

        $q.notify({
          type: 'positive',
          message: 'Removed',
          position: 'top-right',
        });
      });
    };

    return {
      needShowError,
      postalCode,
      removePostalCode,
    };
  }
});
</script>
