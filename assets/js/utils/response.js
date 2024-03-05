import { Notify } from 'quasar';

const successResponse = (payload = '') => {
  return {
    success: true,
    payload,
  };
};

const errorResponse = (message = '', errors = []) => {
  if (message?.length) {
    Notify.create({
      type: 'negative',
      message: message,
      position: 'top-right',
    });
  }

  return {
    success: false,
    errors: errors,
  };
};

export {
  successResponse,
  errorResponse,
};
