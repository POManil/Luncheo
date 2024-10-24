import { useAxios } from '../../config/AxiosContext';
import { useMutation, useQueryClient } from '@tanstack/react-query';

const upsertOrderLine = async (client, orderLine) => {
  try {
    const res = await client.post("/order-line", orderLine);
    return res;
  } catch (error) {
    console.error(error);
    throw error;
  }
}

export const useUpsertOrderLine = () => {
  const client = useAxios();
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({orderLine}) => upsertOrderLine(client, orderLine),
    onSettled: () => {
      queryClient.invalidateQueries({ queryKey: ['orders'] });
    },
  });
};