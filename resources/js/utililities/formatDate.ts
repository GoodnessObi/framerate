import { formatDistance, parseISO } from 'date-fns';

const formatDate = (date: string) => {
    return formatDistance(parseISO(date), new Date(), { addSuffix: true });
};

export default formatDate;