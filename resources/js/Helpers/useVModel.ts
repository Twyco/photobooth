import { computed } from 'vue';

export function useVModel(props: any, propName: string, emit: any) {
  return computed({
    get: () => props[propName],
    set: (value) => emit(`update:${propName}`, value)
  });
}
