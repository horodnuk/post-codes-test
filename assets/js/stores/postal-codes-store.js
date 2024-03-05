import { defineStore } from 'pinia';
import api from '../api/index.js';
import { API_ROUTES, getRoute } from '../api/routes.js';
import { errorResponse, successResponse } from '../utils/response.js';
import { LoadingBar } from 'quasar';

export const usePostalCodesStore = defineStore('postalCodes', {
  state: () => ({
    postalCode: null,
    postalCodes: [],
  }),

  getters: {
    getPostalCode: (state) => state.postalCode,
    getPostalCodes: (state) => state.postalCodes,
  },

  actions: {
    async loadAll(query) {
      try {
        LoadingBar.start();

        const requestQuery = { ...query };
        requestQuery.page = requestQuery?.page ?? 1;

        const postalCodesUrl = getRoute(API_ROUTES['postal_codes.all']);
        const { data } = await api.get(postalCodesUrl, {
          params: requestQuery,
        });

        this.postalCodes = data.data;

        return successResponse(this.postalCodes);
      } catch (exception) {
        this.postalCodes = null;

        return errorResponse(exception?.response?.data?.statusCode?.error?.type ?? '', exception?.response?.data?.statusCode?.error?.description);
      } finally {
        LoadingBar.stop();
      }
    },

    async load(code) {
      try {
        LoadingBar.start();

        const postalCodeUrl = getRoute(API_ROUTES['postal_codes.get'], {
          code,
        });

        const { data } = await api.get(postalCodeUrl);

        this.postalCode = data.data;

        return successResponse(this.postalCodes);
      } catch (exception) {
        this.postalCodes = null;

        return errorResponse(exception?.response?.data?.statusCode?.error?.type ?? '', exception?.response?.data?.statusCode?.error?.description);
      } finally {
        LoadingBar.stop();
      }
    },

    async create(payload) {
      try {
        LoadingBar.start();

        const createUrl = getRoute(API_ROUTES['postal_codes.create']);

        const { data } = await api.post(createUrl, payload);

        return successResponse(data.data);
      } catch (exception) {
        return errorResponse(exception?.response?.data?.data?.message ?? '', exception?.response?.data?.data?.errors);
      } finally {
        LoadingBar.stop();
      }
    },

    async remove(postalCode) {
      try {
        LoadingBar.start();

        const removeUrl = getRoute(API_ROUTES['postal_codes.remove'], {
          code: postalCode,
        });

        await api.delete(removeUrl);

        return successResponse();
      } catch (exception) {
        return errorResponse(exception?.response?.data?.statusCode?.error?.type ?? '', exception?.response?.data?.statusCode?.error?.description);
      } finally {
        LoadingBar.stop();
      }
    },
  },
});
