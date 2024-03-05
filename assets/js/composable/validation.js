import { reactive, ref } from 'vue';

export const useValidation = () => {
  const formEl = ref(null);
  const errors = reactive({});

  const setErrors = (payload) => {
    errors.value = payload;
  };

  const hasError = (field) => {
    return errors?.value?.[field]?.[0]?.length > 0;
  };

  const getError = (field) => {
    if (hasError(field)) {
      return errors?.value?.[field]?.[0];
    }

    return '';
  };

  const removeError = (field) => {
    if (errors?.value?.[field]?.[0]?.length > 0) {
      delete errors.value[field];
    }
  };

  const resetErrors = () => {
    formEl?.value?.resetValidation();
  };

  return {
    formEl,
    errors,

    setErrors,
    hasError,
    removeError,
    getError,
    resetErrors,
  };
};
