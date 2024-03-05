<template>
  <q-dialog ref="dialogRef" @hide="onDialogHide">
    <q-card class="q-dialog-plugin full-width">
      <q-card-section>
        <q-form>
          <div class="row q-gutter-md">
            <div class="col">
              <q-input
                outlined
                dense
                label="Область"
                class="q-mb-md"
                v-model="form.region"
                :rules="[val => !!val || 'Field is required']"
                :error="formValidation.hasError('region')"
                :error-message="formValidation.getError('region')"
                @update:model-value="formValidation.removeError('region')"
              />
            </div>

            <div class="col">
              <q-input
                outlined
                dense
                label="Region (Oblast)"
                class="q-mb-md"
                v-model="form.region_eng"
              />
            </div>
          </div>

          <div class="row q-gutter-md">
            <div class="col">
              <q-input
                outlined
                dense
                label="Район (старий)"
                class="q-mb-md"
                v-model="form.district_old"
              />
            </div>

            <div class="col">
              <q-input
                outlined
                dense
                label="Район (новий)"
                class="q-mb-md"
                v-model="form.district_new"
              />
            </div>
          </div>

          <div class="q-mb-md">
            <q-input
              outlined
              dense
              label="District new (Raion new)"
              class="q-mb-md"
              v-model="form.district_new_eng"
            />
          </div>

          <div class="row q-gutter-md">
            <div class="col">
              <q-input
                outlined
                dense
                label="Поштовий індекс (Postal code)"
                class="q-mb-md"
                mask="#####"
                v-model="form.postal_code"
                :rules="[val => !!val || 'Field is required']"
                :error="formValidation.hasError('postal_code')"
                :error-message="formValidation.getError('postal_code')"
                @update:model-value="formValidation.removeError('postal_code')"
              />
            </div>

            <div class="col">
              <q-input
                outlined
                dense
                label="Поштовий індекс відділення зв`язку (Post code of post office)"
                class="q-mb-md"
                v-model="form.post_code"
                mask="#####"
                :rules="[val => !!val || 'Field is required']"
                :error="formValidation.hasError('post_code')"
                :error-message="formValidation.getError('post_code')"
                @update:model-value="formValidation.removeError('post_code')"
              />
            </div>
          </div>

          <div class="row q-gutter-md">
            <div class="col">
              <q-input
                outlined
                dense
                label="Населений пункт"
                class="q-mb-md"
                v-model="form.settlement"
              />
            </div>

            <div class="col">
              <q-input
                outlined
                dense
                label="Settlement"
                class="q-mb-md"
                v-model="form.settlement_eng"
              />
            </div>
          </div>

          <div class="row q-gutter-md">
            <div class="col">
              <q-input
                outlined
                dense
                label="Вiддiлення зв`язку"
                class="q-mb-md"
                v-model="form.post_office"
              />
            </div>

            <div class="col">
              <q-input
                outlined
                dense
                label="Post office"
                class="q-mb-md"
                v-model="form.post_office_eng"
              />
            </div>
          </div>
        </q-form>
      </q-card-section>

      <q-card-actions align="right" class="q-pa-md q-gutter-md">
        <q-btn
          color="negative"
          label="Cancel"
          @click="onDialogCancel"
        />

        <q-btn
          color="primary"
          label="Create"
          @click="onOKClick"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { useDialogPluginComponent } from 'quasar';
import { defineComponent, reactive, ref } from 'vue';
import { usePostalCodesStore } from '../stores/postal-codes-store.js';
import pinia from '../stores/index.js';
import { useValidation } from '../composable/validation.js';

export default defineComponent({
  emits: [
    ...useDialogPluginComponent.emits
  ],

  setup() {
    const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } = useDialogPluginComponent();

    const postalCodeStore = usePostalCodesStore(pinia());

    const form = reactive({
      region: null,
      district_old: null,
      district_new: null,
      settlement: null,
      postal_code: null,
      post_code: null,
      region_eng: null,
      district_new_eng: null,
      settlement_eng: null,
      post_office: null,
      post_office_eng: null,
    });

    const formValidation = useValidation();

    const onOKClick = async () => {
      const response = await postalCodeStore.create(form);

      if (!response?.success) {
        formValidation.setErrors(response?.errors);

        return;
      }

      onDialogOK(response.payload);

      onDialogHide();
    };

    return {
      dialogRef,
      onDialogHide,
      onDialogCancel,

      onOKClick,

      form,
      formValidation,
    };
  },
});
</script>

<style lang="scss">
.q-dialog-plugin {
  width: max-content;
}
</style>
