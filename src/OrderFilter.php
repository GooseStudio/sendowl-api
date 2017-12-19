<?php
namespace GooseStudio\SendOwlAPI;


class OrderFilter {
	/**
	 * @var string
	 */
	private $fromDate;
	/**
	 * @var string
	 */
	private $toDate;
	/**
	 * @var string
	 */
	private $state;
	/**
	 * @var int
	 */
	private $affiliate;

	/**
	 * @return string
	 */
	public function getFromDate(): string {
		return $this->fromDate;
	}

	/**
	 * @param string $fromDate
	 */
	public function setFromDate( string $fromDate ) {
		$this->fromDate = $fromDate;
	}

	/**
	 * @return string
	 */
	public function getToDate(): string {
		return $this->toDate;
	}

	/**
	 * @param string $toDate
	 */
	public function setToDate( string $toDate ) {
		$this->toDate = $toDate;
	}

	/**
	 * @return string
	 */
	public function getState(): string {
		return $this->state;
	}

	/**
	 * @param string $state
	 */
	public function setState( string $state ) {
		$this->state = $state;
	}

	/**
	 * @return int
	 */
	public function getAffiliate(): int {
		return $this->affiliate;
	}

	/**
	 * @param int $affiliate
	 */
	public function setAffiliate( int $affiliate ) {
		$this->affiliate = $affiliate;
	}

	/**
	 * @return bool
	 */
	public function isNewestFirst(): bool {
		return $this->newest_first;
	}

	/**
	 * @param bool $newest_first
	 */
	public function setNewestFirst( bool $newest_first ) {
		$this->newest_first = $newest_first;
	}

	/**
	 * @var bool
	 */
	private $newest_first;

	/**
	 * OrderQuery constructor.
	 *
	 * @param string $fromDate
	 * @param string $toDate
	 * @param string $state
	 * @param int $affiliate
	 * @param bool $newest_first
	 */
	public function __construct( string $fromDate='', string $toDate='', string $state=OrderStates::Complete, int $affiliate=0, bool $newest_first = true ) {
		$this->fromDate     = $fromDate;
		$this->toDate       = $toDate;
		$this->state        = $state;
		$this->affiliate    = $affiliate;
		$this->newest_first = $newest_first;
	}

	/**
	 * @return string
	 */
	public function buildQueryArgument() : string {
		$filter = [];
		if ($this->getFromDate()){
			$filter[] = 'from='.$this->getFromDate();
		}
		if ($this->getToDate()){
			$filter[] = 'to='.$this->getToDate();
		}
		if ($this->getState()){
			$filter[] = 'state='.$this->getState();
		}
		if ($this->getAffiliate()){
			$filter[] = 'affiliate='.$this->getAffiliate();
		}
		if ($this->isNewestFirst()){
			$filter[] = 'sort=newest_first';
		}
		return implode('&', $filter);
	}
}
