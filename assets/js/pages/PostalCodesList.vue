<template>
  <div class="q-mt-lg q-gutter-md">
    <q-table
      v-model:pagination="postalCodesPagination"
      class="my-sticky-header-table"
      flat bordered
      title="Postal codes"
      :rows-per-page-options="[0]"
      :rows="postalCodesFiltered"
      :columns="postalCodeColumns"
      :loading="isLoadingItems"
      binary-state-sort
      column-sort-order="ad"
      row-key="name"
      hide-pagination
      @request="postalCodesPaginate"
      @row-click="openPostalCode"
    >

      <template v-slot:top>
        <q-btn
          dense
          color="primary"
          :disable="isLoadingItems"
          label="Add postal code"
          @click.prevent="addPostalCode"
        />

        <q-space></q-space>

        <q-input
          v-model="postalCodesSearch"
          outlined
          dense
          debounce="500"
          color="black"
          clearable
        >
          <template v-slot:append>
            <q-icon name="search"></q-icon>
          </template>
        </q-input>
      </template>

      <template v-slot:body-cell-action="props">
        <q-td :props="props">
          <q-btn
            color="negative"
            icon-right="delete"
            no-caps
            flat
            dense
            @click.prevent.stop="removePostalCode(postalCodesFiltered?.indexOf(props.row), props.row)"
          />
        </q-td>
      </template>
    </q-table>

    <div
      v-if="postalCodesPagination.rowsNumber > 0"
      class="row justify-center q-mt-md"
    >
      <q-pagination
        v-model="postalCodesPagination.page"
        color="grey-8"
        :max-pages="postalCodesPagination.pagesMax < 7 ? postalCodesPagination.pagesMax : 7"
        :max="postalCodesPagination.pagesMax"
        size="sm"
        direction-links
        boundary-numbers
        @update:model-value="postalCodesPaginate"
      />
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue';

import { usePostalCodes } from '../composable/postal-codes.js';
import { useQuasar } from 'quasar';
import AddNewPostalCode from '../components/AddNewPostalCode.vue';
import { usePostalCodesStore } from '../stores/postal-codes-store.js';
import pinia from '../stores/index.js';
import { useRouter } from 'vue-router';

export default defineComponent({
  name: 'PostalCodesList',

  async setup() {
    const $q = useQuasar();
    const router = useRouter();

    const postalCodeStore = usePostalCodesStore(pinia());

    const {
      filtered: postalCodesFiltered,
      pagination: postalCodesPagination,
      loading: isLoadingItems,

      search: postalCodesSearch,
      paginate: postalCodesPaginate,
    } = await usePostalCodes();

    const postalCodeColumns = [
      {
        name: 'region',
        required: true,
        label: 'Область',
        align: 'left',
        field: row => row.region,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'district_old',
        required: true,
        label: 'Район (старий)',
        align: 'left',
        field: row => row.district_old,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'district_new',
        required: true,
        label: 'Район (новий)',
        align: 'left',
        field: row => row.district_new,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'settlement',
        required: true,
        label: 'Населений пункт',
        align: 'left',
        field: row => row.settlement,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'postal_code',
        required: true,
        label: 'Поштовий індекс (Postal code)',
        align: 'left',
        field: row => row.postal_code,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'region_eng',
        required: true,
        label: 'Region (Oblast)',
        align: 'left',
        field: row => row.region_eng,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'district_new_eng',
        required: true,
        label: 'District new (Raion new)',
        align: 'left',
        field: row => row.district_new_eng,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'settlement_eng',
        required: true,
        label: 'Settlement',
        align: 'left',
        field: row => row.settlement_eng,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'post_office',
        required: true,
        label: 'Вiддiлення зв`язку',
        align: 'left',
        field: row => row.post_office,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'post_office_eng',
        required: true,
        label: 'Post office',
        align: 'left',
        field: row => row.post_office_eng,
        format: val => `${val}`,
        sortable: true,
      },

      {
        name: 'post_code',
        required: true,
        label: 'Поштовий індекс відділення зв`язку (Post code of post office)',
        align: 'left',
        field: row => row.post_code,
        format: val => `${val}`,
        sortable: true,
      },

      { name: 'action', label: 'Action', field: 'action' }
    ];

    const addPostalCode = () => {
      $q.dialog({
        component: AddNewPostalCode,
      }).onOk(async (payload) => {
        postalCodesFiltered?.value?.push(payload);

        $q.notify({
          type: 'positive',
          message: 'Success',
          position: 'top-right',
        });
      });
    };

    const removePostalCode = (idx, payload) => {
      $q.dialog({
        title: 'Confirm',
        message: 'Are you sure you want to delete the entry?',
        cancel: true,
        persistent: true
      }).onOk(async () => {
        const response = await postalCodeStore.remove(payload.post_code);

        if (!response?.success) {
          $q.notify({
            type: 'negative',
            message: 'Error remove',
            position: 'top-right',
          });
          return;
        }

        postalCodesFiltered?.value?.splice(idx, 1);

        $q.notify({
          type: 'positive',
          message: 'Removed',
          position: 'top-right',
        });
      });
    };

    const openPostalCode = (evt, row, index) => {
      $q.dialog({
        title: 'Open postal code page?',
        cancel: true,
        persistent: false
      }).onOk(() => {
        router.push({ name: 'pages.postal_codes.get', params: { code: row.post_code } });
      });
    };

    return {
      postalCodeColumns,

      postalCodesFiltered,
      postalCodesPagination,
      isLoadingItems,

      addPostalCode,
      removePostalCode,
      postalCodesPaginate,
      postalCodesSearch,

      openPostalCode,
    };
  }
});
</script>
