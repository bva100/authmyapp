<?php

class Mandrill_Rejects {
    public function __construct(Mandrill $master) {
        $this->master = $master;
    }

    /**
     * Retrieves your email rejection blacklist. You can provide an email
address to limit the results. Returns up to 1000 results. By default,
entries that have expired are excluded from the results; set
include_expired to true to include them.
     * @param string $email an optional email address to search by
     * @param boolean $include_expired whether to include rejections that have already expired.
     * @return array Up to 1000 rejection entries
     *     - return[] struct the information for each rejection blacklist entry
     *         - email string the email that is blocked
     *         - reason string the type of event (hard-bounce, soft-bounce, spam, unsub) that caused this rejection
     *         - created_at string when the email was added to the blacklist
     *         - expires_at string when the blacklist entry will expire (this may be in the past)
     *         - expired boolean whether the blacklist entry has expired
     *         - sender struct the sender that this blacklist entry applies to, or null if none.
     *             - address string the sender's email address
     *             - created_at string the date and time that the sender was first seen by Mandrill as a UTC date string in YYYY-MM-DD HH:MM:SS format
     *             - sent integer the total number of messages sent by this sender
     *             - hard_bounces integer the total number of hard bounces by messages by this sender
     *             - soft_bounces integer the total number of soft bounces by messages by this sender
     *             - rejects integer the total number of rejected messages by this sender
     *             - complaints integer the total number of spam complaints received for messages by this sender
     *             - unsubs integer the total number of unsubscribe requests received for messages by this sender
     *             - opens integer the total number of times messages by this sender have been opened
     *             - clicks integer the total number of times tracked URLs in messages by this sender have been clicked
     */
    public function getList($email=null, $include_expired=false) {
        $_params = array("email" => $email, "include_expired" => $include_expired);
        return $this->master->call('rejects/list', $_params);
    }

    /**
     * Deletes an email rejection. There is no limit to how many rejections
you can remove from your blacklist, but keep in mind that each deletion
has an affect on your reputation.
     * @param string $email an email address
     * @return struct a status object containing the address and whether the deletion succeeded.
     *     - email string the email address that was removed from the blacklist
     *     - deleted boolean whether the address was deleted successfully.
     */
    public function delete($email) {
        $_params = array("email" => $email);
        return $this->master->call('rejects/delete', $_params);
    }

}


