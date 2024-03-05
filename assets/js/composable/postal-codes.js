import { computed, ref, watch } from 'vue';
import { usePostalCodesStore } from '../stores/postal-codes-store.js';
import { useRoute } from 'vue-router';
import pinia from '../stores/index.js';

export const usePostalCodes = async () => {
  const route = useRoute();

  const search = ref(null);

  const postalCodesStore = usePostalCodesStore(pinia());
  await postalCodesStore.loadAll(route.query);

  const postalCodes = computed(() => postalCodesStore.getPostalCodes);
  const filtered = computed(() => {
    return postalCodes?.value?.items ?? [];
  });

  const pagination = ref({});

  watch(() => postalCodes, () => {
    pagination.value.sortBy = postalCodes?.value?.sort_by ?? 'post_code';
    pagination.value.descending = postalCodes?.value?.descending;
    pagination.value.page = parseInt(postalCodes?.value?.current_page) ?? 1;
    pagination.value.rowsPerPage = postalCodes?.value?.per_page;
    pagination.value.rowsNumber = postalCodes?.value?.total;
    pagination.value.pagesMax = postalCodes?.value?.total_page;
    pagination.value.search = search.value ?? '';
  }, {
    deep: true,
    immediate: true,
  });

  const loading = ref(false);

  const paginate = async (props) => {
    if (loading.value) {
      return;
    }

    loading.value = true;

    if (props?.pagination) {
      pagination.value.sortBy = props.pagination.sortBy;
      pagination.value.descending = props.pagination.descending;
    }

    await postalCodesStore.loadAll({
      page: pagination.value?.page ?? 1,
      sortBy: props?.pagination?.sortBy,
      descending: pagination.value.descending,
      search: pagination.value?.search ?? '',
    });

    loading.value = false;
  };

  watch(() => search, async () => {
    pagination.value.search = search.value;

    await paginate();
  }, {
    deep: true,
    immediate: true,
  });

  return {
    filtered,
    pagination,
    search,

    loading,
    paginate,
  };
};
