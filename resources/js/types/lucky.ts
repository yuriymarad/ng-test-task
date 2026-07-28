export type LuckyDrawResult = 'win' | 'lose';

export type LuckyDraw = {
    number: number;
    result: LuckyDrawResult;
    amount: number;
    createdAt: string | null;
};

export type AccessLink = {
    token: string;
    url: string;
    expiresAt: string;
};

export type LuckyParticipant = {
    name: string;
};
