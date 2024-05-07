<?php
    function infor($totalmoney,$numoftrans,$numofproduct,$totalprofit,$numofcanceltrans,$totalmoneyofcanceltrans){
        echo '<div class="container">';
        echo '<div class="row ">
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-warning p-3 mb-2">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-8">
                                    <h4 class="text-white">'.$totalmoney.'</h4>
                                    <h6 class="text-white ">Tổng số tiền đã nhận</h6>
                                </div>
                                <div class="col-4 text-write">
                                    <h4 class="text-white"><i class="fa fa-money fa-2x"></i></h4>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-danger p-3 mb-2">
                        <div class="card-block">
                            <div class="row ">
                                <div class="col-8">
                                    <h4 class="text-white">'.$numoftrans.'</h4>
                                    <h6 class="text-white">Số lượng đơn hàng</h6>
                                </div>
                                <div class="col-4 text-write">
                                    <h4 class="text-white"><i class="fa fa-file-text-o fa-2x"></i></h4>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-success p-3 mb-2">
                        <div class="card-block">
                            <div class="row ">
                                <div class="col-8">
                                    <h4 class="text-white">'.$numofproduct.'</h4>
                                    <h6 class="text-white">Số lượng sản phẩm đã bán</h6>
                                </div>
                                <div class="col-4 text-write">
                                    <h4 class="text-white"><i class="fa fa-check-square-o fa-2x"></i></h4>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="row ">
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-secondary p-3 mb-2">
                        <div class="card-block">
                            <div class="row ">
                                <div class="col-8">
                                    <h4 class="text-white">'.$totalprofit.'</h4>
                                    <h6 class="text-white">Tổng lợi nhuận</h6>
                                </div>  
                                <div class="col-4 text-write">
                                    <h4 class="text-white"><i class="fa fa-line-chart fa-2x"></i></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-dark p-3 mb-2">
                        <div class="card-block">
                            <div class="row ">
                                <div class="col-8">
                                    <h4 class="text-white">'.$numofcanceltrans.'</h4>
                                    <h6 class="text-white">Số đơn đã hủy</h6>
                                </div>  
                                <div class="col-4 text-write">
                                    <h4 class="text-white"><i class="fa fa-close fa-2x"></i></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-info p-3 mb-2">
                        <div class="card-block">
                            <div class="row ">
                                <div class="col-8">
                                    <h4 class="text-white">'.$totalmoneyofcanceltrans.'</h4>
                                    <h6 class="text-white">Số tiền mất do hủy đơn</h6>
                                </div>  
                                <div class="col-4 text-write">
                                    <h4 class="text-white"><i class="fa fa-angle-double-down fa-2x"></i></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';  
        echo "</div>";                                     
    }
    function tablehead(){
        echo '<div style="overflow-x:auto;">';
        echo '<table class="table table-bordered ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày Mua</th>
                    <th>Tổng Số Tiền</th>
                    <th>Số Tiền Khách Đã Đưa</th>
                    <th>Tiền Thối</th>
                    <th>Số Lượng Sản Phẩm</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>';
    }
    function tablebody($transaction){
        echo"<tr>";
            echo "<td>".$transaction->getId()."</td>";
            echo "<td>".$transaction->getCreated()->format('d/m/Y H:i:s')."</td>";
            $total = 0;
            foreach ($transaction->getItems() as $item) : 
                $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
            endforeach;
            echo "<td>".$total."</td>";
            echo "<td>".$transaction->getGivenMoney()."</td>";

                $change = $transaction->getGivenMoney() - $total;
                if ($change < 0) {
                    $change=0;
                }
            echo "<td>".$change."</td>";
                $totalquantity = 0;
                foreach ($transaction->getItems() as $item) : 
                    $totalquantity += $item->getQuantity() ;
                endforeach;
            echo "<td>".$totalquantity."</td>";
            echo "<td>";
                echo '<button type="button" class="btn btn-primary getDetailBnt"><span><i class="fa-solid fa-circle-info"></i></span> Chi tiết</button>';
                
            echo "</td>";
        echo "</tr>";
    }
    //theo moc thoi gian
    if(isset($_GET['timestart'])&&isset($_GET['timeend'])){
        $timestartstr = $_GET['timestart'];
        $timeendstr = $_GET['timeend'];
        $timestart = strtotime($timestartstr);
        $timeend = strtotime($timeendstr);
        $totalmoney=0;
        $numoftrans=0;
        $numofproduct=0;
        $totalprofit=0;
        $numofcanceltrans = 0;
        $totalmoneyofcanceltrans = 0;
        foreach($transactions as $transaction){
            $time = strtotime($transaction->getCreated()->format('Y-m-d'));
            if($time>=$timestart&&$time<=$timeend){
                if($transaction->getIsCanceled()==true){
                    $numofcanceltrans++;
                        foreach ($transaction->getItems() as $item){ 
                            $totalmoneyofcanceltrans += $item->getProduct()->getProfit() * $item->getQuantity() ;
                        }
                    continue;
                }
                $numoftrans++;
                $total=0;
                $profit=0;
                
                foreach ($transaction->getItems() as $item) : 
                    $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                    $numofproduct+=$item->getQuantity();
                    $profit += $item->getProduct()->getProfit() * $item->getQuantity();
                endforeach;
                $totalmoney+=$total;
                $totalprofit+=$profit;
            }
        }
        infor($totalmoney,$numoftrans,$numofproduct,$totalprofit,$numofcanceltrans,$totalmoneyofcanceltrans);
        tablehead();
                foreach($transactions as $transaction):
                    if($transaction->getIsCanceled()==true){
                        continue;
                    }
                    $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                    if($time>=$timestart&&$time<=$timeend){
                        tablebody($transaction);
                    }
                endforeach; 
                echo "</tbody>";
                echo "</table>";
            echo "</div>";
    }
    //theo loai thoi gian
    if( isset($_GET['timerange']) && ( isset($_GET['timeend'])==false || isset($_GET['timeend'])==false ) ){
        $timerange = $_GET['timerange'];
        $totalmoney=0;
        $numoftrans=0;
        $numofproduct=0;
        $timestart = 0;
        $timeend = 0;
        $totalprofit=0;
        $numofcanceltrans = 0;
        $totalmoneyofcanceltrans = 0;
        if($timerange == 'today'){
            $timestart = strtotime("today");
            $timeend = strtotime("tomorrow")-1;
            foreach($transactions as $transaction){
                $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                if($time>=$timestart&&$time<=$timeend){
                    if($transaction->getIsCanceled()==true){
                        $numofcanceltrans++;
                        foreach ($transaction->getItems() as $item){ 
                            $totalmoneyofcanceltrans += $item->getProduct()->getProfit() * $item->getQuantity() ;
                        }
                        continue;
                    }
                    $numoftrans++;
                    $total=0;
                    $profit=0;
                    
                    foreach ($transaction->getItems() as $item) : 
                        $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                        $numofproduct+=$item->getQuantity();
                        $profit += $item->getProduct()->getProfit() * $item->getQuantity();
                    endforeach;
                    $totalmoney+=$total;
                    $totalprofit+=$profit;
                }
            }
            infor($totalmoney,$numoftrans,$numofproduct,$totalprofit,$numofcanceltrans,$totalmoneyofcanceltrans);
            tablehead();
                    foreach($transactions as $transaction):
                        if($transaction->getIsCanceled()==true){
                            continue;
                        }
                        $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                        if($time>=$timestart&&$time<=$timeend){
                            tablebody($transaction);
                        }
                    endforeach; 
                    echo "</tbody>";
                    echo "</table>";
                echo "</div>";
        }
        if($timerange == 'yesterday'){
            $timestart = strtotime("yesterday");
            $timeend = strtotime("today")-1;
            foreach($transactions as $transaction){
                $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                if($time>=$timestart&&$time<=$timeend){
                    if($transaction->getIsCanceled()==true){
                        $numofcanceltrans++;
                        foreach ($transaction->getItems() as $item){ 
                            $totalmoneyofcanceltrans += $item->getProduct()->getProfit() * $item->getQuantity() ;
                        }
                        continue;
                    }
                    $numoftrans++;
                    $total=0;
                    $profit=0;
                    
                    foreach ($transaction->getItems() as $item) : 
                        $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                        $numofproduct+=$item->getQuantity();
                        $profit += $item->getProduct()->getProfit() * $item->getQuantity();
                    endforeach;
                    $totalmoney+=$total;
                    $totalprofit+=$profit;
                }
            }
            infor($totalmoney,$numoftrans,$numofproduct,$totalprofit,$numofcanceltrans,$totalmoneyofcanceltrans);
            tablehead();
                    foreach($transactions as $transaction):
                        if($transaction->getIsCanceled()==true){
                            continue;
                        }
                        $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                        if($time>=$timestart&&$time<=$timeend){
                            tablebody($transaction);
                        }
                    endforeach; 
                    echo "</tbody>";
                    echo "</table>";
                echo "</div>";
        }
        if($timerange == '7day'){
            $timestart = strtotime("-7 day");
            $timeend = strtotime("today")-1;
            foreach($transactions as $transaction){
                $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                if($time>=$timestart&&$time<=$timeend){
                    if($transaction->getIsCanceled()==true){
                        $numofcanceltrans++;
                        foreach ($transaction->getItems() as $item){ 
                            $totalmoneyofcanceltrans += $item->getProduct()->getProfit() * $item->getQuantity() ;
                        }
                        continue;
                    }
                    $numoftrans++;
                    $total=0;
                    $profit=0;
                    
                    foreach ($transaction->getItems() as $item) : 
                        if($transaction->getIsCanceled()==true){
                            continue;
                        }
                        $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                        $numofproduct+=$item->getQuantity();
                        $profit += $item->getProduct()->getProfit() * $item->getQuantity();
                    endforeach;
                    $totalmoney+=$total;
                    $totalprofit+=$profit;
                }
            }
            infor($totalmoney,$numoftrans,$numofproduct,$totalprofit,$numofcanceltrans,$totalmoneyofcanceltrans);
            tablehead();
                    foreach($transactions as $transaction):
                        if($transaction->getIsCanceled()==true){
                            continue;
                        }
                        $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                        if($time>=$timestart&&$time<=$timeend){
                            tablebody($transaction);
                        }
                    endforeach; 
                    echo "</tbody>";
                    echo "</table>";
                echo "</div>";
        }
        if($timerange == 'month'){
            $timestart = strtotime("first day of this month");
            $timeend = strtotime("last day of this month 23:59:59");
            foreach($transactions as $transaction){
                $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                if($time>=$timestart&&$time<=$timeend){
                    if($transaction->getIsCanceled()==true){
                        $numofcanceltrans++;
                        foreach ($transaction->getItems() as $item){ 
                            $totalmoneyofcanceltrans += $item->getProduct()->getProfit() * $item->getQuantity() ;
                        }
                        continue;
                    }
                    $numoftrans++;
                    $total=0;
                    $profit=0;
                    
                    foreach ($transaction->getItems() as $item) : 
                        if($transaction->getIsCanceled()==true){
                            continue;
                        }
                        $total += $item->getProduct()->getPrice() * $item->getQuantity() ;
                        $numofproduct+=$item->getQuantity();
                        $profit += $item->getProduct()->getProfit() * $item->getQuantity();
                    endforeach;
                    $totalmoney+=$total;
                    $totalprofit+=$profit;
                }
            }
            infor($totalmoney,$numoftrans,$numofproduct,$totalprofit,$numofcanceltrans,$totalmoneyofcanceltrans);
            tablehead();
                    foreach($transactions as $transaction):
                        if($transaction->getIsCanceled()==true){
                            continue;
                        }
                        $time = strtotime($transaction->getCreated()->format('Y-m-d'));
                        if($time>=$timestart&&$time<=$timeend){
                            tablebody($transaction);
                        }
                    endforeach; 
                    echo "</tbody>";
                    echo "</table>";
                echo "</div>";
        }
    }
    
        
    