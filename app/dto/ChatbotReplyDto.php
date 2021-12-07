<?php


namespace app\dto;

class ChatbotReplyDto extends BaseDto
{
	protected $conversationId = '';
	protected $atUsers = [];
	protected $chatbotCorpId = '';
	protected $chatbotUserId = '';
	protected $msgId = '';
	protected $senderNick = '';
	protected $isAdmin = false;
	protected $senderStaffId = '';
	protected $sessionWebhookExpiredTime = '';
	protected $createAt = 0;
	protected $senderCorpId = '';
	protected $conversationType = 0;
	protected $senderId = '';
	protected $conversationTitle = '';
	protected $isInAtList = false;
	protected $sessionWebhook = '';
	protected $text = [];
	protected $robotCode = [];
	protected $msgtype = '';

	/**
	 * @return string
	 */
	public function getConversationId()
	{
		return $this->conversationId;
	}

	/**
	 * @param string $conversationId
	 */
	public function setConversationId($conversationId)
	{
		$this->conversationId = $conversationId;
	}

	/**
	 * @return array
	 */
	public function getAtUsers()
	{
		return $this->atUsers;
	}

	/**
	 * @param array $atUsers
	 */
	public function setAtUsers($atUsers)
	{
		$this->atUsers = $atUsers;
	}

	/**
	 * @return string
	 */
	public function getChatbotCorpId()
	{
		return $this->chatbotCorpId;
	}

	/**
	 * @param string $chatbotCorpId
	 */
	public function setChatbotCorpId($chatbotCorpId)
	{
		$this->chatbotCorpId = $chatbotCorpId;
	}

	/**
	 * @return string
	 */
	public function getChatbotUserId()
	{
		return $this->chatbotUserId;
	}

	/**
	 * @param string $chatbotUserId
	 */
	public function setChatbotUserId($chatbotUserId)
	{
		$this->chatbotUserId = $chatbotUserId;
	}

	/**
	 * @return string
	 */
	public function getMsgId()
	{
		return $this->msgId;
	}

	/**
	 * @param string $msgId
	 */
	public function setMsgId($msgId)
	{
		$this->msgId = $msgId;
	}

	/**
	 * @return string
	 */
	public function getSenderNick()
	{
		return $this->senderNick;
	}

	/**
	 * @param string $senderNick
	 */
	public function setSenderNick($senderNick)
	{
		$this->senderNick = $senderNick;
	}

	/**
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->isAdmin;
	}

	/**
	 * @param bool $isAdmin
	 */
	public function setIsAdmin($isAdmin)
	{
		$this->isAdmin = $isAdmin;
	}

	/**
	 * @return string
	 */
	public function getSenderStaffId()
	{
		return $this->senderStaffId;
	}

	/**
	 * @param string $senderStaffId
	 */
	public function setSenderStaffId($senderStaffId)
	{
		$this->senderStaffId = $senderStaffId;
	}

	/**
	 * @return string
	 */
	public function getSessionWebhookExpiredTime()
	{
		return $this->sessionWebhookExpiredTime;
	}

	/**
	 * @param string $sessionWebhookExpiredTime
	 */
	public function setSessionWebhookExpiredTime($sessionWebhookExpiredTime)
	{
		$this->sessionWebhookExpiredTime = $sessionWebhookExpiredTime;
	}

	/**
	 * @return int
	 */
	public function getCreateAt()
	{
		return $this->createAt;
	}

	/**
	 * @param int $createAt
	 */
	public function setCreateAt($createAt)
	{
		$this->createAt = $createAt;
	}

	/**
	 * @return string
	 */
	public function getSenderCorpId()
	{
		return $this->senderCorpId;
	}

	/**
	 * @param string $senderCorpId
	 */
	public function setSenderCorpId($senderCorpId)
	{
		$this->senderCorpId = $senderCorpId;
	}

	/**
	 * @return int
	 */
	public function getConversationType()
	{
		return $this->conversationType;
	}

	/**
	 * @param int $conversationType
	 */
	public function setConversationType($conversationType)
	{
		$this->conversationType = $conversationType;
	}

	/**
	 * @return string
	 */
	public function getSenderId()
	{
		return $this->senderId;
	}

	/**
	 * @param string $senderId
	 */
	public function setSenderId($senderId)
	{
		$this->senderId = $senderId;
	}

	/**
	 * @return string
	 */
	public function getConversationTitle()
	{
		return $this->conversationTitle;
	}

	/**
	 * @param string $conversationTitle
	 */
	public function setConversationTitle($conversationTitle)
	{
		$this->conversationTitle = $conversationTitle;
	}

	/**
	 * @return bool
	 */
	public function isInAtList()
	{
		return $this->isInAtList;
	}

	/**
	 * @param bool $isInAtList
	 */
	public function setIsInAtList($isInAtList)
	{
		$this->isInAtList = $isInAtList;
	}

	/**
	 * @return string
	 */
	public function getSessionWebhook()
	{
		return $this->sessionWebhook;
	}

	/**
	 * @param string $sessionWebhook
	 */
	public function setSessionWebhook($sessionWebhook)
	{
		$this->sessionWebhook = $sessionWebhook;
	}

	/**
	 * @return array
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @param array $text
	 */
	public function setText($text)
	{
		$this->text = $text;
	}

	/**
	 * @return array
	 */
	public function getRobotCode()
	{
		return $this->robotCode;
	}

	/**
	 * @param array $robotCode
	 */
	public function setRobotCode($robotCode)
	{
		$this->robotCode = $robotCode;
	}

	/**
	 * @return string
	 */
	public function getMsgtype()
	{
		return $this->msgtype;
	}

	/**
	 * @param string $msgtype
	 */
	public function setMsgtype($msgtype)
	{
		$this->msgtype = $msgtype;
	}

}
