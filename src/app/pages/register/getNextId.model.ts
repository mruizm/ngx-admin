export interface GenNextId {
    status_code: string;
    response: {
        record_type: string;
        record_action: string;
        record_id: string;
        transaction_id: string;
    }
}