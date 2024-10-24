import { useAxios } from '../../config/AxiosContext';
import { useMutation, useQueryClient } from '@tanstack/react-query';
import { upsertOrderLine } from './upsertOrderLine';

export const useUpsertOrderLines = () => {
  const client = useAxios();
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({orderLine}) => {
      upsertOrderLine(client, orderLine)
    },
    onSettled: () => {
      queryClient.invalidateQueries({ queryKey: ['orders'] });
    },
  });
};