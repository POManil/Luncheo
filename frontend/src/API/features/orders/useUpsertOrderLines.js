import { useAxios } from '../../config/AxiosContext';
import { useMutation, useQueryClient } from '@tanstack/react-query';
import { upsertOrderLine } from './upsertOrderLine';

export const useUpsertOrderLines = () => {
  const client = useAxios();
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({orderLine}) => upsertOrderLine(client, orderLine),
    onMutate: async (orderLine) => {
      await queryClient.cancelQueries({queryKey: ['orders']});
      const prevState = queryClient.getQueryData(['orders']);

      queryClient.setQueryData(['orders'], (old = []) => [
        ...old,
        { ...orderLine, status: 'optimistic' }
      ]);

      return prevState;
    },
    onSettled: () => {
      queryClient.invalidateQueries({ queryKey: ['orders'] });
    },
  });
};