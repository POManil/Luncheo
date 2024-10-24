import { useAxios } from '../../config/AxiosContext';
import { useMutation, useQueryClient } from '@tanstack/react-query';

const deleteOrderLine = async (client, orderLine) => {
  const params = new URLSearchParams();
  params.append('orderId', orderLine.orderId);
  params.append('userId', orderLine.userId);
  params.append('sandwichId', orderLine.sandwichId);

  const queryUrl = `/order-line?${params}`;

  try {
    const res = await client.delete(queryUrl);
    return res;
  } catch (error) {
    console.error(error);
    throw error;
  }
}

export const useDeleteOrderLine = () => {
  const client = useAxios();
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({orderLine}) => deleteOrderLine(client, orderLine),
    onSettled: () => {
      queryClient.invalidateQueries({ queryKey: ['orders'] });
    },
  });
};