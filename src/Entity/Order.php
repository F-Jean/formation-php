<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 30/07/17
 * Time: 15:20
 */

namespace Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class Order
 * @package Entity
 *
 * @Entity
 * @Table(name="shop_order")
 * @HasLifecycleCallbacks
 */
class Order
{
    /**
     * @var integer
     *
     * @Id
     * @GeneratedValue
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @Column(name="address", type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @Column(name="zip", type="string", length=255)
     */
    private $zip;

    /**
     * @var string
     *
     * @Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @Column(name="ordered_at", type="datetime")
     */
    private $orderedAt;

    /**
     * @var string
     *
     * @Column(name="num", type="string", length=255, nullable=true)
     */
    private $num;

    /**
     * @var float
     *
     * @Column(name="total_et", type="decimal", precision=10, scale=2)
     */
    private $totalET;

    /**
     * @var float
     *
     * @Column(name="total_it", type="decimal", precision=10, scale=2)
     */
    private $totalIT;

    /**
     * @var float
     *
     * @Column(name="total_vat", type="decimal", precision=10, scale=2)
     */
    private $totalVAT;

    /**
     * @var array
     *
     * @OneToMany(targetEntity="OrderLine", mappedBy="order", cascade={"persist","remove"})
     */
    private $lines;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getOrderedAt()
    {
        return $this->orderedAt;
    }

    /**
     * @param string $orderedAt
     */
    public function setOrderedAt($orderedAt)
    {
        $this->orderedAt = $orderedAt;
    }

    /**
     * @return string
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param string $num
     */
    public function setNum($num)
    {
        $this->num = $num;
    }

    /**
     * @return string
     */
    public function getTotalET()
    {
        return $this->totalET;
    }

    /**
     * @param string $totalET
     */
    public function setTotalET($totalET)
    {
        $this->totalET = $totalET;
    }

    /**
     * @return string
     */
    public function getTotalIT()
    {
        return $this->totalIT;
    }

    /**
     * @param string $totalIT
     */
    public function setTotalIT($totalIT)
    {
        $this->totalIT = $totalIT;
    }

    /**
     * @return string
     */
    public function getTotalVAT()
    {
        return $this->totalVAT;
    }

    /**
     * @param string $totalVAT
     */
    public function setTotalVAT($totalVAT)
    {
        $this->totalVAT = $totalVAT;
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param array $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }

    /**
     * @param OrderLine $orderLine
     */
    public function addLine(OrderLine $orderLine)
    {
        $orderLine->setOrder($this);
        $this->lines[] = $orderLine;
    }

    /**
     * @PrePersist()
     */
    public function prePersist()
    {
        $this->setTotalET(array_reduce($this->lines,function($total,OrderLine $line){
            $total += $line->getProduct()->getPriceET()*$line->getQuantity();
            return $total;
        }));
        $this->setTotalIT(array_reduce($this->lines,function($total,OrderLine $line){
            $total += $line->getProduct()->getPriceIT()*$line->getQuantity();
            return $total;
        }));
        $this->setTotalVAT(array_reduce($this->lines,function($total,OrderLine $line){
            $total += $line->getProduct()->getPriceET()*$line->getProduct()->getVat()*$line->getQuantity();
            return $total;
        }));
        $this->setOrderedAt(new \DateTime());
    }

    /**
     * @PostPersist()
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $this->setNum("BCB-".$this->id);
        $em = $eventArgs->getEntityManager();
        $em->flush();
    }
}